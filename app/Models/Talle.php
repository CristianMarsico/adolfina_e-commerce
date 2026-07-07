<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_talle')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
