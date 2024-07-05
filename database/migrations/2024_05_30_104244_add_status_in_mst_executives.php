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
        Schema::table('mst_executives', function (Blueprint $table) {
            $table->tinyInteger('status')->comment('1=>on')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_executives', function (Blueprint $table) {
            $table->dropColumn(['name']);
        });
    }
};
