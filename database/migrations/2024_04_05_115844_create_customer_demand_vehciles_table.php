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
        Schema::create('customer_demand_vehciles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('party_id')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('budget')->nullable();
            $table->string('fuel_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_demand_vehciles');
    }
};
