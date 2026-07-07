<?php

namespace App\Listeners;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;

class MigrateSessionCartToDatabase
{
    public function handle(Login $event): void
    {
        if ($event->user->is_admin) {
            return;
        }

        $cart = session()->pull('cart', []);

        if (empty($cart)) {
            return;
        }

        foreach ($cart as $item) {
            $query = CartItem::where('user_id', $event->user->id)
                ->where('producto_id', $item['producto_id']);

            $atributoId = $item['atributo_id'] ?? null;

            if ($atributoId) {
                $query->where('atributo_id', $atributoId);
            } else {
                $query->whereNull('atributo_id');
            }

            $existing = $query->first();

            if ($existing) {
                $existing->increment('cantidad', $item['cantidad']);
            } else {
                CartItem::create([
                    'user_id' => $event->user->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'atributo_id' => $atributoId,
                ]);
            }
        }
    }
}
