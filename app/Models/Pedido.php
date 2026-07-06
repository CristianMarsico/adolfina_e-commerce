<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'subtotal',
        'descuento',
        'estado',
        'direccion',
        'ciudad',
        'codigo_postal',
        'telefono',
        'observaciones',
        'mp_preference_id',
        'mp_payment_id',
        'mp_status',
        'mp_merchant_order_id',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'descuento' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
