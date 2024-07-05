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
        Schema::create('health_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_id')->nullable();
            $table->string('member_name')->nullable();
            $table->string('sum_assured')->nullable();
            $table->string('end_date')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('hospital_name')->nullable();
            $table->string('claim_amount')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Pending, 1: closed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_insurances');
    }
};
