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
        Schema::create('term_insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mst_party_id')->nullable();
            $table->unsignedBigInteger('mst_executive_id')->nullable();
            $table->string('insurance_company')->nullable();
            $table->tinyInteger('insurance_type')->default(null);
            $table->date('insurance_done_date')->nullable();
            $table->date('insurance_from_date')->nullable();
            $table->date('insurance_to_date')->nullable();
            $table->string('premium_payment_period')->nullable();
            $table->string('premium')->nullable();
            $table->string('gst')->nullable();
            $table->string('sum_insured')->nullable();
            $table->string('total')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('coverage_upto')->nullable();
            $table->string('coverage_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_insurances');
    }
};
