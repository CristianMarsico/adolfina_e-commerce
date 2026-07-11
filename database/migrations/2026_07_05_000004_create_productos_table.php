<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->foreignId('marca_id')->nullable()->constrained('marcas')->nullOnDelete();
            $table->foreignId('etapa_id')->nullable()->constrained('etapas')->nullOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->text('edad_talla')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('destacado')->default(false);
            $table->boolean('tiene_talla')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
