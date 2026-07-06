<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promociones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'valor_descuento' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'promocion_producto');
    }

    public function scopeActiva($query)
    {
        return $query->where('activo', true)
            ->where('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now());
    }
}
