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
        Schema::create('health_insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_number_id')->nullable();
            $table->unsignedBigInteger('mst_party_id')->nullable();
            $table->string('survyour_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('dealer')->nullable();
            $table->string('status')->nullable();
            $table->string('state_id')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_insurance_claims');
    }
};
