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
        Schema::dropIfExists('car_loans');

        Schema::create('car_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mst_party_id')->nullable();
            $table->unsignedBigInteger('mst_model_id')->nullable();
            $table->unsignedBigInteger('mst_dealer_id')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('brand')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->string('registration_year')->nullable();
            $table->string('kilometer')->nullable();
            $table->string('expectation')->nullable();
            $table->date('date_of_purchase')->nullable();
            $table->string('owners')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('shape_type')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->boolean('service_booklet')->nullable();
            $table->string('color')->nullable();
            $table->date('insurance_done_date')->nullable();
            $table->date('insurance_from_date')->nullable();
            $table->date('insurance_to_date')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('status')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_amount')->nullable();
            $table->string('state_id')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_loans');
    }
};
