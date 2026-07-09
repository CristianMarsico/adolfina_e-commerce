<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Producto extends Model
{
    protected $fillable = [
        'categoria_id',
        'marca_id',
        'etapa_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'edad_talla',
        'activo',
        'destacado',
        'tiene_talla',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function etapa()
    {
        return $this->belongsTo(Etapa::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ProductoImagen::class)->where('es_principal', true);
    }

    public function atributos()
    {
        return $this->hasMany(ProductoAtributo::class);
    }

    public function promociones()
    {
        return $this->belongsToMany(Promocion::class, 'promocion_producto');
    }

    public function getDescuentoAttribute(): ?Promocion
    {
        $promociones = $this->relationLoaded('promociones')
            ? $this->relations['promociones']
            : $this->promociones()->get();

        $activa = $promociones
            ->where('activo', true)
            ->where('fecha_inicio', '<=', now()->startOfDay())
            ->where('fecha_fin', '>=', now()->startOfDay())
            ->sortByDesc('valor_descuento')
            ->first();

        return $activa;
    }

    public function getPrecioOfertaAttribute(): ?float
    {
        $oferta = $this->descuento;

        if (!$oferta) {
            return null;
        }

        if ($oferta->tipo_descuento === 'porcentaje') {
            return round($this->precio * (1 - $oferta->valor_descuento / 100), 2);
        }

        return max(0, $this->precio - $oferta->valor_descuento);
    }

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'activo' => 'boolean',
            'destacado' => 'boolean',
            'tiene_talla' => 'boolean',
        ];
    }
}
