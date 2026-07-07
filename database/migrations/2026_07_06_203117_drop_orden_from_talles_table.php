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
        Schema::table('talles', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }

    public function down(): void
    {
        Schema::table('talles', function (Blueprint $table) {
            $table->integer('orden')->default(0);
        });
    }
};
