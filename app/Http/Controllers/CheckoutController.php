<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function getCart()
    {
        if (Auth::check() && !Auth::user()->is_admin) {
            $cartItems = \App\Models\CartItem::where('user_id', Auth::id())->get();
            $cart = [];

            foreach ($cartItems as $item) {
                $producto = $item->producto;
                $key = $producto->id . '-' . ($item->atributo_id ?? '0');
                $precio = (float) $producto->precio;
                $atributoNombre = null;

                if ($item->atributo_id) {
                    $atributo = $producto->atributos()->find($item->atributo_id);
                    if ($atributo) {
                        $precio += (float) $atributo->precio_adicional;
                        $atributoNombre = $atributo->valor;
                    }
                }

                $cart[$key] = [
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $precio,
                    'cantidad' => $item->cantidad,
                    'atributo_id' => $item->atributo_id,
                    'atributo_nombre' => $atributoNombre,
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
            $precio = $item['precio'];
            $subtotal = $precio * $item['cantidad'];
            $total += $subtotal;

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

        $productos = \App\Models\Producto::whereIn('id', collect($cart)->pluck('producto_id'))->get()->keyBy('id');

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
                    'atributo_info' => $item['atributo_nombre'] ?? null,
                ];

                $mpItems[] = [
                    'producto_id' => $item['producto_id'],
                    'nombre' => $item['nombre'],
                    'descripcion' => $item['atributo_nombre'] ?? '',
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

            $preferencia = $mp->crearPreferencia(
                $mpItems,
                ['name' => $request->nombre, 'email' => $request->email],
                (string) $pedido->id,
                [
                    'success' => route('checkout.exito', [$pedido, 'token' => $token]),
                    'failure' => route('checkout.falla', [$pedido, 'token' => $token]),
                    'pending' => route('checkout.pendiente', [$pedido, 'token' => $token]),
                    'notification' => route('webhook.mp'),
                ]
            );

            $pedido->update(['mp_preference_id' => $preferencia->id]);

            if (Auth::check() && !Auth::user()->is_admin) {
                \App\Models\CartItem::where('user_id', Auth::id())->delete();
            } else {
                session()->forget('cart');
            }

            DB::commit();

            $pedido->load('items');
            return view('tienda.pagando', [
                'pedido' => $pedido,
                'initPoint' => $preferencia->init_point,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
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
