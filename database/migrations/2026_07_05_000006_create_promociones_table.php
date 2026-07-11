<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo_descuento', ['porcentaje', 'fijo'])->default('porcentaje');
            $table->decimal('valor_descuento', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('promocion_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promocion_id')->constrained('promociones')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['promocion_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promocion_producto');
        Schema::dropIfExists('promociones');
    }
};
