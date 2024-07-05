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
        Schema::table('car_loans', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_type')->nullable();
            $table->unsignedBigInteger('car_type')->nullable();
        });

        Schema::table('mst_models', function (Blueprint $table) {
            $table->unsignedBigInteger('luxury')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_loans', function (Blueprint $table) {
            $table->dropColumn('loan_type');
            $table->dropColumn('car_type');
        });

        Schema::table('mst_models', function (Blueprint $table) {
            $table->dropColumn('luxury');
        });
    }
};
