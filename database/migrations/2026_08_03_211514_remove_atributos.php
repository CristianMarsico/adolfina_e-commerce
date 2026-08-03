<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedido_items', function (Blueprint $table) {
            $table->dropForeign(['atributo_id']);
            $table->dropColumn('atributo_id');
            $table->dropColumn('atributo_info');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'producto_id', 'atributo_id']);
            $table->dropColumn('atributo_id');
        });

        Schema::dropIfExists('producto_atributos');

        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['user_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'producto_id']);
            $table->unsignedBigInteger('atributo_id')->nullable();
            $table->unique(['user_id', 'producto_id', 'atributo_id']);
        });

        Schema::create('producto_atributos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->string('tipo');
            $table->string('valor');
            $table->decimal('precio_adicional', 10, 2)->default(0);
            $table->integer('stock')->nullable();
            $table->timestamps();
        });

        Schema::table('pedido_items', function (Blueprint $table) {
            $table->string('atributo_info')->nullable();
            $table->foreignId('atributo_id')->nullable()->constrained('producto_atributos')->nullOnDelete();
        });
    }
};
