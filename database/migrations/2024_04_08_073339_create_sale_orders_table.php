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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->nullable();
            $table->foreignId('purchase_id')->nullable();
            $table->string('icompany_id')->nullable();
            $table->string('ncb_insurance')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('reg_date')->nullable();
            $table->string('insurance_due_date')->nullable();
            $table->string('status')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_orders');
    }
};
