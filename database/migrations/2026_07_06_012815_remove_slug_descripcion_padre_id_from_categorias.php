<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropForeign(['padre_id']);
            $table->dropColumn(['slug', 'descripcion', 'padre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('padre_id')->nullable()->constrained('categorias')->cascadeOnDelete();
        });
    }
};
