<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->foreignId('etapa_id')->nullable()->after('marca_id')->constrained('etapas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['etapa_id']);
            $table->dropColumn('etapa_id');
        });

        Schema::dropIfExists('etapas');
    }
};
