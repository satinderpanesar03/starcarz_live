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
        Schema::create('refurbnishment_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->nullable();
            $table->foreignId('purchase_id')->nullable();
            $table->string('status')->nullable();
            $table->string('service_and_oil_change')->nullable();
            $table->integer('service_and_oil_change_amount')->nullable();
            $table->string('compound_and_dry_clean')->nullable();
            $table->integer('compound_and_dry_clean_amount')->nullable();
            $table->string('paint_and_denting')->nullable();
            $table->integer('paint_and_denting_amount')->nullable();
            $table->string('electrical_and_electronics')->nullable();
            $table->integer('electrical_and_electronics_amount')->nullable();
            $table->string('engine_compartment')->nullable();
            $table->integer('engine_compartment_amount')->nullable();
            $table->string('accessories')->nullable();
            $table->integer('accessories_amount')->nullable();
            $table->string('others_desc')->nullable();
            $table->integer('others_amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refurbnishment_orders');
    }
};
