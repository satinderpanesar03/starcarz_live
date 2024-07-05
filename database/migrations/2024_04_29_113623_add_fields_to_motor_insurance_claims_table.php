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
        Schema::table('motor_insurance_claims', function (Blueprint $table) {
            $table->date('policy_start_date')->nullable();
            $table->date('policy_end_date')->nullable();
            $table->string('claim_details')->nullable();
        });

        Schema::table('health_insurance_claims', function (Blueprint $table) {
            $table->string('hospital_name')->nullable();
            $table->string('claim_details')->nullable();
        });

        Schema::table('general_insurance_claims', function (Blueprint $table) {
            $table->string('claim_details')->nullable();
        });

        Schema::table('term_insurance_claims', function (Blueprint $table) {
            $table->string('claim_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insurance_claims', function (Blueprint $table) {
            //
        });
    }
};
