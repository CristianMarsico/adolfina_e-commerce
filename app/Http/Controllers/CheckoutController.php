<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
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
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:20',
            'telefono' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $user = Auth::user();
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

            $pedido = Pedido::create([
                'user_id' => $user->id,
                'total' => $total,
                'subtotal' => $subtotal + $totalDescuento,
                'descuento' => $totalDescuento,
                'estado' => 'pendiente',
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'codigo_postal' => $request->codigo_postal,
                'telefono' => $request->telefono,
                'observaciones' => $request->observaciones,
            ]);

            foreach ($itemsPedido as $item) {
                $pedido->items()->create($item);
            }

            $preferencia = $mp->crearPreferencia(
                $mpItems,
                ['name' => $user->name, 'email' => $user->email],
                (string) $pedido->id,
                [
                    'success' => route('checkout.exito', $pedido),
                    'failure' => route('checkout.falla', $pedido),
                    'pending' => route('checkout.pendiente', $pedido),
                    'notification' => route('webhook.mp'),
                ]
            );

            $pedido->update(['mp_preference_id' => $preferencia->id]);

            session()->forget('cart');

            DB::commit();

            return redirect($preferencia->init_point);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function exito(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }
        $pedido->load('items.producto');
        return view('tienda.pedido-exito', compact('pedido'));
    }

    public function falla(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tienda.pedido-falla', compact('pedido'));
    }

    public function pendiente(Pedido $pedido)
    {
        if ($pedido->user_id !== Auth::id()) {
            abort(403);
        }
        return view('tienda.pedido-pendiente', compact('pedido'));
    }
}
