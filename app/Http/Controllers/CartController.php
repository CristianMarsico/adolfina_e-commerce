<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
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
            'atributo_id' => 'nullable|exists:producto_atributos,id',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        $cart = session()->get('cart', []);

        $cartItem = [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'slug' => $producto->slug,
            'precio' => (float) $producto->precio,
            'cantidad' => (int) $request->cantidad,
            'atributo_id' => $request->atributo_id,
        ];

        if ($request->atributo_id) {
            $atributo = $producto->atributos()->find($request->atributo_id);
            if ($atributo) {
                $cartItem['precio'] += (float) $atributo->precio_adicional;
                $cartItem['atributo_nombre'] = $atributo->valor;
            }
        }

        $key = $producto->id . '-' . ($request->atributo_id ?? '0');

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
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['cantidad'] = max(1, (int) $request->cantidad);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function destroy($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }
}
