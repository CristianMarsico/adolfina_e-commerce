<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->string('email')->nullable();
            $table->decimal('total', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->string('estado')->default('pendiente');
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('telefono')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('token', 64)->nullable()->unique();
            $table->string('mp_preference_id')->nullable()->unique();
            $table->string('mp_payment_id')->nullable();
            $table->string('mp_status')->nullable();
            $table->string('mp_merchant_order_id')->nullable();
            $table->timestamps();
        });

        Schema::create('pedido_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
            $table->string('nombre');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->string('atributo_info')->nullable();
            $table->foreignId('atributo_id')->nullable()->constrained('producto_atributos')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
        Schema::dropIfExists('pedidos');
    }
};
