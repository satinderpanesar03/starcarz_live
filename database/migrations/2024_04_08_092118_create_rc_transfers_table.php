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
        Schema::create('rc_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->nullable();
            $table->foreignId('vehicle_id')->nullable();
            $table->foreignId('agent_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('transfer_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rc_transfers');
    }
};
