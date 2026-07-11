<?php

namespace App\Providers;

use App\Listeners\MigrateSessionCartToDatabase;
use App\Models\CartItem;
use App\Models\Categoria;
use App\Models\Configuracion;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        try {
            $configuracion = Configuracion::firstOrCreate(['id' => 1]);
        } catch (\Exception $e) {
            $configuracion = new Configuracion();
        }

        View::share('configuracion', $configuracion);

        View::composer('layouts.tienda', function ($view) {
            if (Auth::check() && !Auth::user()->is_admin) {
                $cartCount = CartItem::where('user_id', Auth::id())->sum('cantidad');
            } else {
                $cart = session()->get('cart', []);
                $cartCount = collect($cart)->sum('cantidad');
            }

            $categoriasNav = Categoria::where('activo', true)->get();

            $view->with('cartCount', $cartCount)->with('categoriasNav', $categoriasNav);
        });

        Event::listen(Login::class, MigrateSessionCartToDatabase::class);
    }
}
