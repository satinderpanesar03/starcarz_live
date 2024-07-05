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
        Schema::create('insurance_renewal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insurance_id')->nullable();
            $table->date('insurance_from_date')->nullable();
            $table->date('insurance_to_date')->nullable();
            $table->string('premium')->nullable();
            $table->string('gst')->nullable();
            $table->string('sum_insured')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_renewal_details');
    }
};
