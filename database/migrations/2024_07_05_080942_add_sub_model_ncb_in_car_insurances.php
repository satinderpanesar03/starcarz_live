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
        Schema::table('car_insurances', function (Blueprint $table) {
            $table->string('sub_model')->nullable();
            $table->string('ncb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_insurances', function (Blueprint $table) {
            $table->dropColumn(['sub_model','ncb']);
        });
    }
};
