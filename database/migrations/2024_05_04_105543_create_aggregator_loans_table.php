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
        Schema::create('aggregator_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('person_name')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('loan_number')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
            $table->unsignedBigInteger('executive')->nullable();
            $table->string('policy_number')->nullable();
            $table->date('insurance_valid_date')->nullable();
            $table->unsignedBigInteger('insurance_company')->nullable();
            $table->string('state_id')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aggregator_loans');
    }
};
