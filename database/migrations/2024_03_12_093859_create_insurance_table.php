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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('firm_name')->length(65);
            $table->string('person_name')->lenght(65);
            $table->bigInteger('whatsapp_number')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_city')->nullable();
            $table->bigInteger('office_number')->nullable();
            $table->string('residence_address')->nullable();
            $table->string('residence_city')->nullable();
            $table->bigInteger('residence_number')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('pan_number')->nullable();
            $table->foreignId('executive_id');
            $table->integer('insurance_id');
            $table->foreignId('insurance_type_id');
            $table->dateTime('insurance_date');
            $table->dateTime('insurance_from_date');
            $table->dateTime('insurance_to_date');
            $table->foreignId('company_id');
            $table->integer('premium')->nullable();
            $table->integer('gst');
            $table->integer('total');
            $table->integer('sum_assured')->nullable();
            $table->integer('insured_by');
            $table->integer('policy_number');
            $table->foreignId('broker_id');
            $table->string('broker_percentage')->nullable();
            $table->string('coverge_detail');
            $table->string('covered_insurance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
