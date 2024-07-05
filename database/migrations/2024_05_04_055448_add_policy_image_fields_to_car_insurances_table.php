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
            $table->string('policy_image')->nullable();
        });
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->string('policy_image')->nullable();
        });
        Schema::table('general_insurances', function (Blueprint $table) {
            $table->string('policy_image')->nullable();
        });
        Schema::table('term_insurances', function (Blueprint $table) {
            $table->string('policy_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_insurances', function (Blueprint $table) {
            $table->dropColumn('policy_image');
        });
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->dropColumn('policy_image');
        });
        Schema::table('general_insurances', function (Blueprint $table) {
            $table->dropColumn('policy_image');
        });
        Schema::table('term_insurances', function (Blueprint $table) {
            $table->dropColumn('policy_image');
        });
    }
};
