<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Api\ProductoController as ApiProductoController;
use Illuminate\Support\Facades\Route;

// Public store routes
Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::get('/contacto', [ContactController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactController::class, 'enviar'])->name('contacto.enviar');
Route::get('/productos', [ProductoController::class, 'catalogo'])->name('productos.catalogo');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('/categoria/{categoria}', [ProductoController::class, 'porCategoria'])->name('productos.categoria');

// Cart routes
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carrito/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/{key}', [CartController::class, 'destroy'])->name('cart.destroy');

// Checkout routes (sin auth — invitados también pueden comprar)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');

Route::get('/checkout/{pedido}/exito', [CheckoutController::class, 'exito'])->name('checkout.exito');
Route::get('/checkout/{pedido}/falla', [CheckoutController::class, 'falla'])->name('checkout.falla');
Route::get('/checkout/{pedido}/pendiente', [CheckoutController::class, 'pendiente'])->name('checkout.pendiente');

// Webhooks (no auth)
Route::post('/webhook/mp', [WebhookController::class, 'mp'])->name('webhook.mp');

// API (live updates)
Route::get('/api/productos/{producto}/precio', [ApiProductoController::class, 'precio'])->name('api.productos.precio');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
