<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('cantidad')->default(1);
            $table->unsignedBigInteger('atributo_id')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'producto_id', 'atributo_id']);
        });

        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_negocio')->default('Pañalera');
            $table->text('descripcion')->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('horarios')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
        Schema::dropIfExists('cart_items');
    }
};
