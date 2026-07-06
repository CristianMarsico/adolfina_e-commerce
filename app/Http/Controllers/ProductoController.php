<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $destacados = Producto::where('activo', true)
            ->where('destacado', true)
            ->with('imagenPrincipal', 'promociones')
            ->latest()
            ->take(8)
            ->get();

        $nuevos = Producto::where('activo', true)
            ->with('imagenPrincipal', 'promociones')
            ->latest()
            ->take(8)
            ->get();

        $categorias = Categoria::where('activo', true)
            ->withCount(['productos' => function ($q) {
                $q->where('activo', true);
            }])
            ->get();

        return view('tienda.home', compact('destacados', 'nuevos', 'categorias'));
    }

    public function catalogo(Request $request)
    {
        $query = Producto::where('activo', true)->with('imagenPrincipal', 'categoria', 'promociones');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%");
            });
        }

        if ($request->filled('categorias')) {
            $query->whereIn('categoria_id', $request->categorias);
        }

        if ($request->filled('marcas')) {
            $query->whereIn('marca', $request->marcas);
        }

        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', (float) $request->precio_min);
        }

        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', (float) $request->precio_max);
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('precio');
                break;
            case 'price_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'name':
                $query->orderBy('nombre');
                break;
            default:
                $query->latest();
                break;
        }

        $productos = $query->paginate(12)->withQueryString();

        $categorias = Categoria::where('activo', true)->get();
        $marcas = Producto::where('activo', true)->distinct()->pluck('marca')->filter();

        return view('tienda.catalogo', compact('productos', 'categorias', 'marcas'));
    }

    public function show(Producto $producto)
    {
        if (!$producto->activo) {
            abort(404);
        }

        $producto->load('imagenes', 'atributos', 'categoria', 'promociones');

        $relacionados = Producto::where('activo', true)
            ->where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->with('imagenPrincipal', 'promociones')
            ->take(4)
            ->get();

        return view('tienda.producto-show', compact('producto', 'relacionados'));
    }

    public function porCategoria(Categoria $categoria)
    {
        $productos = Producto::where('activo', true)
            ->where('categoria_id', $categoria->id)
            ->with('imagenPrincipal', 'promociones')
            ->latest()
            ->paginate(12);

        return view('tienda.categoria', compact('categoria', 'productos'));
    }
}
