<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    protected $fillable = [
        'categoria_id',
        'nombre',
        'slug',
        'descripcion',
        'marca',
        'precio',
        'stock',
        'edad_talla',
        'activo',
        'destacado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            if (empty($producto->slug)) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
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

    public function talles()
    {
        return $this->belongsToMany(Talle::class, 'producto_talle')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function ofertaActiva()
    {
        return $this->belongsToMany(Promocion::class, 'promocion_producto')
            ->wherePivot('producto_id', $this->id)
            ->where('activo', true)
            ->where('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->orderBy('valor_descuento', 'desc');
    }

    public function getPrecioOfertaAttribute()
    {
        $oferta = $this->promociones()
            ->where('activo', true)
            ->where('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->orderBy('valor_descuento', 'desc')
            ->first();

        if (!$oferta) {
            return null;
        }

        if ($oferta->tipo_descuento === 'porcentaje') {
            return round($this->precio * (1 - $oferta->valor_descuento / 100), 2);
        }

        return max(0, $this->precio - $oferta->valor_descuento);
    }

    public function getDescuentoAttribute()
    {
        $oferta = $this->promociones()
            ->where('activo', true)
            ->where('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->orderBy('valor_descuento', 'desc')
            ->first();

        return $oferta;
    }
}
