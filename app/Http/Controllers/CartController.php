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
            $cartItems = CartItem::with('producto.atributos', 'producto.imagenPrincipal')
                ->where('user_id', auth()->id())
                ->get();
            $cart = [];
            $productos = collect();

            foreach ($cartItems as $item) {
                $producto = $item->producto;
                if (!$producto) continue;
                $key = $producto->id . '-' . ($item->atributo_id ?? '0');
                $precio = (float) $producto->precio;
                $atributoNombre = null;

                if ($item->atributo_id) {
                    $atributo = $producto->atributos->firstWhere('id', $item->atributo_id);
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
            'atributo_id' => 'nullable|exists:producto_atributos,id',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if (auth()->check() && !auth()->user()->is_admin) {
            $query = CartItem::where('user_id', auth()->id())
                ->where('producto_id', $producto->id);

            if ($request->atributo_id) {
                $query->where('atributo_id', $request->atributo_id);
            } else {
                $query->whereNull('atributo_id');
            }

            $existing = $query->first();

            if ($existing) {
                $existing->increment('cantidad', (int) $request->cantidad);
            } else {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'producto_id' => $producto->id,
                    'cantidad' => (int) $request->cantidad,
                    'atributo_id' => $request->atributo_id,
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
        if (auth()->check() && !auth()->user()->is_admin) {
            $parts = explode('-', $key);
            $productoId = $parts[0] ?? null;
            $atributoId = isset($parts[1]) && $parts[1] !== '0' ? $parts[1] : null;

            if (!$productoId) {
                return redirect()->route('cart.index');
            }

            $query = CartItem::where('user_id', auth()->id())
                ->where('producto_id', $productoId);

            if ($atributoId) {
                $query->where('atributo_id', $atributoId);
            } else {
                $query->whereNull('atributo_id');
            }

            $query->update(['cantidad' => max(1, (int) $request->cantidad)]);

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
            $parts = explode('-', $key);
            $productoId = $parts[0] ?? null;
            $atributoId = isset($parts[1]) && $parts[1] !== '0' ? $parts[1] : null;

            if (!$productoId) {
                return redirect()->route('cart.index');
            }

            $query = CartItem::where('user_id', auth()->id())
                ->where('producto_id', $productoId);

            if ($atributoId) {
                $query->where('atributo_id', $atributoId);
            } else {
                $query->whereNull('atributo_id');
            }

            $query->delete();

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
