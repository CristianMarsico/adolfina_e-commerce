<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'orden' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Talle $talle) {
            if ($talle->orden === null) {
                $talle->orden = static::max('orden') + 1;
            }
        });
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_talle')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
