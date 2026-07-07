<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('producto_talle', function (Blueprint $table) {
            $table->unique(['producto_id', 'talle_id']);
        });
    }

    public function down(): void
    {
        Schema::table('producto_talle', function (Blueprint $table) {
            $table->dropUnique(['producto_id', 'talle_id']);
        });
    }
};
