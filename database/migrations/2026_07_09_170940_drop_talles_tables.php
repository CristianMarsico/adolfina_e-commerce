<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('producto_talle');
        Schema::dropIfExists('talles');

        if (Schema::hasColumn('productos', 'tiene_talles')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('tiene_talles');
            });
        }
    }

    public function down(): void
    {
        Schema::create('talles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('producto_talle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
            $table->foreignId('talle_id')->constrained('talles')->cascadeOnDelete();
            $table->integer('stock')->default(0);
            $table->timestamps();
            $table->unique(['producto_id', 'talle_id']);
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->boolean('tiene_talles')->default(true);
        });
    }
};
