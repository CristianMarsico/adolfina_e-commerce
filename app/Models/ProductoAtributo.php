<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoAtributo extends Model
{
    protected $fillable = [
        'producto_id',
        'tipo',
        'valor',
        'precio_adicional',
        'stock',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
