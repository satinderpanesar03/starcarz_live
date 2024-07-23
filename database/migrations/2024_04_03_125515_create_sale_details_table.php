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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->nullable();
            $table->string('vehicle_id')->nullable();
            $table->string('suggestion_vehicle_id')->nullable();
            $table->string('car_number')->nullable();
            $table->string('suggestion_car_number')->nullable();
            $table->string('status')->nullable()->default('1');
            $table->string('remarks')->nullable();
            $table->dateTime('followup_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
