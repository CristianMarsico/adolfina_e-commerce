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
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
