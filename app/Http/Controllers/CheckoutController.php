<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CheckoutController extends Controller
{
    private function getCart()
    {
        if (Auth::check() && !Auth::user()->is_admin) {
            $cartItems = \App\Models\CartItem::with('producto')
                ->where('user_id', Auth::id())
                ->get();
            $cart = [];

            foreach ($cartItems as $item) {
                $producto = $item->producto;
                if (!$producto) continue;
                $key = (string) $producto->id;

                $cart[$key] = [
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => (float) $producto->precio,
                    'cantidad' => $item->cantidad,
                ];
            }

            return $cart;
        }

        return session()->get('cart', []);
    }

    public function index()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $productos = \App\Models\Producto::whereIn('id', collect($cart)->pluck('producto_id'))->with('imagenPrincipal')->get()->keyBy('id');

        $total = 0;
        $descuentoTotal = 0;
        foreach ($cart as $item) {
            $producto = $productos->get($item['producto_id']);
            $precioEfectivo = $producto && $producto->precio_oferta && $producto->precio_oferta < $item['precio']
                ? $producto->precio_oferta
                : $item['precio'];
            $total += $precioEfectivo * $item['cantidad'];

            if ($producto && $producto->precio_oferta && $producto->precio_oferta < $item['precio']) {
                $descuentoTotal += ($item['precio'] - $producto->precio_oferta) * $item['cantidad'];
            }
        }

        $user = Auth::user();

        return view('tienda.checkout', compact('cart', 'productos', 'total', 'descuentoTotal', 'user'));
    }

    public function procesar(Request $request, MercadoPagoService $mp)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'telefono' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $productos = \App\Models\Producto::whereIn('id', collect($cart)->pluck('producto_id'))
            ->get()
            ->keyBy('id');

        foreach ($cart as $item) {
            $producto = $productos->get($item['producto_id']);
            if (!$producto || !$producto->activo) {
                return redirect()->route('cart.index')->with('error', "Producto no disponible: {$item['nombre']}");
            }

            $qty = (int) $item['cantidad'];

            if ($producto->stock !== null && $qty > (int) $producto->stock) {
                return redirect()->route('cart.index')->with('error', "Stock insuficiente para {$item['nombre']}. Disponible: {$producto->stock}");
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $itemsPedido = [];
            $mpItems = [];
            $totalDescuento = 0;

            foreach ($cart as $key => $item) {
                $producto = $productos->get($item['producto_id']);
                $precioFinal = $producto && $producto->precio_oferta ? $producto->precio_oferta : $item['precio'];
                $precioOriginal = $item['precio'];
                $subtotalItem = $precioFinal * $item['cantidad'];
                $subtotal += $subtotalItem;

                if ($producto && $producto->precio_oferta) {
                    $totalDescuento += ($precioOriginal - $precioFinal) * $item['cantidad'];
                }

                $itemsPedido[] = [
                    'producto_id' => $item['producto_id'],
                    'nombre' => $item['nombre'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $precioFinal,
                    'subtotal' => $subtotalItem,
                ];

                $mpItems[] = [
                    'producto_id' => $item['producto_id'],
                    'nombre' => $item['nombre'],
                    'descripcion' => '',
                    'cantidad' => $item['cantidad'],
                    'precio' => $precioFinal,
                ];
            }

            $total = $subtotal;

            $token = Str::random(32);

            $pedido = Pedido::create([
                'user_id' => Auth::check() && !Auth::user()->is_admin ? Auth::id() : null,
                'email' => $request->email,
                'total' => $total,
                'subtotal' => $subtotal + $totalDescuento,
                'descuento' => $totalDescuento,
                'estado' => 'pendiente',
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'codigo_postal' => $request->codigo_postal,
                'telefono' => $request->telefono,
                'observaciones' => $request->observaciones,
                'token' => $token,
            ]);

            foreach ($itemsPedido as $item) {
                $pedido->items()->create($item);
            }

            $qr = $mp->crearPedidoQR(
                $mpItems,
                $total,
                (string) $pedido->id,
            );

            $pedido->update([
                'mp_qr_data' => $qr['qr_data'],
                'mp_order_id' => $qr['id'] ?? null,
            ]);

            DB::commit();

            $pedido->load('items');

            $qrSvg = QrCode::format('svg')->size(256)->margin(1)->generate($qr['qr_data']);

            return view('tienda.pagando', [
                'pedido' => $pedido,
                'qrSvg' => $qrSvg,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function estado(Request $request, Pedido $pedido, MercadoPagoService $mp)
    {
        abort_unless($this->autorizarPedido($pedido, $request), 403);

        if ($pedido->estado !== 'pagado' && $pedido->mp_order_id) {
            $order = $mp->obtenerOrdenQR($pedido->mp_order_id);

            if ($order) {
                $approved = false;
                $approvedId = null;

                if (($order['status'] ?? null) === 'processed' && ($order['status_detail'] ?? null) === 'accredited') {
                    $approved = true;
                }

                $payments = $order['transactions']['payments'] ?? $order['payments'] ?? [];

                $terminal = count($payments) > 0;

                foreach ($payments as $payment) {
                    $status = $payment['status'] ?? null;
                    $detail = $payment['status_detail'] ?? null;

                    if ($status === 'approved' || ($status === 'processed' && $detail === 'accredited')) {
                        $approved = true;
                        $approvedId = $payment['reference_id'] ?? $payment['id'] ?? $approvedId;
                    }

                    if ($status !== 'rejected' && $status !== 'cancelled' && $status !== 'refunded' && $status !== 'charged_back') {
                        $terminal = false;
                    }
                }

                if ($approved) {
                    $this->marcarPagado($pedido, (string) ($approvedId ?? $order['id']), $pedido->mp_order_id);
                } elseif ($terminal) {
                    $pedido->update([
                        'mp_status' => 'rejected',
                        'estado' => 'fallado',
                    ]);
                }
            }

            $pedido->refresh();
        }

        return response()->json([
            'estado' => $pedido->estado,
            'pagado' => $pedido->estado === 'pagado',
        ]);
    }

    private function marcarPagado(Pedido $pedido, string $paymentId, ?string $orderId): void
    {
        $estadoAnterior = $pedido->estado;

        $pedido->update([
            'mp_payment_id' => $paymentId,
            'mp_status' => 'approved',
            'mp_merchant_order_id' => $orderId,
            'estado' => 'pagado',
        ]);

        if ($estadoAnterior !== 'pagado') {
            $this->descontarStock($pedido);
        }
    }

    private function descontarStock(Pedido $pedido): void
    {
        foreach ($pedido->items as $item) {
            $producto = \App\Models\Producto::find($item->producto_id);
            if ($producto && $producto->stock !== null) {
                $producto->decrement('stock', $item->cantidad);
            }
        }
    }

    private function autorizarPedido(Pedido $pedido, Request $request): bool
    {
        if ($request->token && $pedido->token === $request->token) {
            return true;
        }

        if (Auth::check() && $pedido->user_id === Auth::id()) {
            return true;
        }

        return false;
    }

    public function exito(Request $request, Pedido $pedido)
    {
        abort_unless($this->autorizarPedido($pedido, $request), 403);

        if (Auth::check() && !Auth::user()->is_admin) {
            \App\Models\CartItem::where('user_id', Auth::id())->delete();
        }
        session()->forget('cart');

        $pedido->load('items.producto');
        return view('tienda.pedido-exito', compact('pedido'));
    }

    public function falla(Request $request, Pedido $pedido)
    {
        abort_unless($this->autorizarPedido($pedido, $request), 403);
        return view('tienda.pedido-falla', compact('pedido'));
    }

    public function pendiente(Request $request, Pedido $pedido)
    {
        abort_unless($this->autorizarPedido($pedido, $request), 403);
        return view('tienda.pedido-pendiente', compact('pedido'));
    }
}
