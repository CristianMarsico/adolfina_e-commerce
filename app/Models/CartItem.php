<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'producto_id', 'cantidad', 'atributo_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
