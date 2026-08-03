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

        if (auth()->check() && !auth()->user()->is_admin) {
            $existing = CartItem::where('user_id', auth()->id())
                ->where('producto_id', $producto->id)
                ->first();

            if ($existing) {
                $existing->increment('cantidad', (int) $request->cantidad);
            } else {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'producto_id' => $producto->id,
                    'cantidad' => (int) $request->cantidad,
                ]);
            }

            return redirect()->back()->with('success', 'Producto agregado al carrito');
        }

        $cart = session()->get('cart', []);

        $cartItem = [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'precio' => (float) $producto->precio,
            'cantidad' => (int) $request->cantidad,
        ];

        $key = (string) $producto->id;

        if (isset($cart[$key])) {
            $cart[$key]['cantidad'] += (int) $request->cantidad;
        } else {
            $cart[$key] = $cartItem;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request, $key)
    {
        if (auth()->check() && !auth()->user()->is_admin) {
            CartItem::where('user_id', auth()->id())
                ->where('producto_id', $key)
                ->update(['cantidad' => max(1, (int) $request->cantidad)]);

            return redirect()->route('cart.index');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['cantidad'] = max(1, (int) $request->cantidad);
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
