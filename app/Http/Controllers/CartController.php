<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Producto;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (auth()->check() && !auth()->user()->is_admin) {
            $cartItems = CartItem::with('producto.imagenPrincipal')
                ->where('user_id', auth()->id())
                ->get();
            $cart = [];
            $productos = collect();

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
                $productos->put($producto->id, $producto);
            }

            return view('tienda.cart', compact('cart', 'productos'));
        }

        $cart = session()->get('cart', []);
        $productos = collect();

        if (!empty($cart)) {
            $ids = collect($cart)->pluck('producto_id')->unique();
            $productos = Producto::whereIn('id', $ids)->with('imagenPrincipal')->get()->keyBy('id');
        }

        return view('tienda.cart', compact('cart', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidadSolicitada = (int) $request->cantidad;
        $stock = (int) $producto->stock;

        if ($stock < 1) {
            return redirect()->back()->with('error', "{$producto->nombre} no tiene stock disponible.");
        }

        if (auth()->check() && !auth()->user()->is_admin) {
            $existing = CartItem::where('user_id', auth()->id())
                ->where('producto_id', $producto->id)
                ->first();
            $existentes = $existing ? (int) $existing->cantidad : 0;
        } else {
            $key = (string) $producto->id;
            $cart = session()->get('cart', []);
            $existentes = isset($cart[$key]) ? (int) $cart[$key]['cantidad'] : 0;
        }

        $disponibles = max(0, $stock - $existentes);

        if ($disponibles < 1) {
            return redirect()->back()->with('error', "Ya tenés el máximo disponible de {$producto->nombre} ({$stock}).");
        }

        $cantidad = min($cantidadSolicitada, $disponibles);
        $capped = $cantidad < $cantidadSolicitada;

        if (auth()->check() && !auth()->user()->is_admin) {
            if ($existing) {
                $existing->increment('cantidad', $cantidad);
            } else {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                ]);
            }
        } else {
            $cartItem = [
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => (float) $producto->precio,
                'cantidad' => $cantidad,
            ];

            if (isset($cart[$key])) {
                $cart[$key]['cantidad'] += $cantidad;
            } else {
                $cart[$key] = $cartItem;
            }

            session()->put('cart', $cart);
        }

        if ($capped) {
            return redirect()->back()->with('error', "Solo quedan {$disponibles} disponibles de {$producto->nombre}. Se agregaron {$cantidad}.");
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, $key)
    {
        $producto = Producto::findOrFail($key);
        $stock = (int) $producto->stock;
        $cantidad = max(1, (int) $request->cantidad);

        if (auth()->check() && !auth()->user()->is_admin) {
            if ($stock < 1) {
                CartItem::where('user_id', auth()->id())
                    ->where('producto_id', $key)
                    ->delete();

                return redirect()->route('cart.index')->with('error', "{$producto->nombre} ya no tiene stock.");
            }

            CartItem::where('user_id', auth()->id())
                ->where('producto_id', $key)
                ->update(['cantidad' => min($cantidad, $stock)]);

            return redirect()->route('cart.index');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($stock < 1) {
                unset($cart[$key]);
                session()->put('cart', $cart);

                return redirect()->route('cart.index')->with('error', "{$producto->nombre} ya no tiene stock.");
            }

            $cart[$key]['cantidad'] = min($cantidad, $stock);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function destroy($key)
    {
        if (auth()->check() && !auth()->user()->is_admin) {
            CartItem::where('user_id', auth()->id())
                ->where('producto_id', $key)
                ->delete();

            return redirect()->route('cart.index');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }
}
