<?php

namespace App\Http\Controllers\Api;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoController
{
    public function precio(Producto $producto): JsonResponse
    {
        $producto->load('promociones');

        return response()->json([
            'id' => $producto->id,
            'precio' => (float) $producto->precio,
            'precio_oferta' => $producto->precio_oferta ? (float) $producto->precio_oferta : null,
            'descuento' => $producto->descuento ? [
                'tipo' => $producto->descuento->tipo_descuento,
                'valor' => (float) $producto->descuento->valor_descuento,
            ] : null,
            'stock' => $producto->stock,
        ]);
    }
}
