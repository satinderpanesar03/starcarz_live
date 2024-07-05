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
        Schema::create('endorsement_insurance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insurance_id')->nullable();
            $table->unsignedBigInteger('policy_id')->nullable();
            $table->string('policy_number')->nullable();
            $table->unsignedBigInteger('insurance_type')->nullable();
            $table->date('date')->nullable();
            $table->string('sum_assured')->nullable();
            $table->string('premium')->nullable();
            $table->string('endorsement_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endorsement_insurance_details');
    }
};
