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
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->foreignId('insurance_company_id')->nullable();
            $table->foreignId('sub_type_id')->nullable();
            $table->foreignId('executive_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->dropColumn(['insurance_company_id','sub_type_id','executive_id']);
        });
    }
};
