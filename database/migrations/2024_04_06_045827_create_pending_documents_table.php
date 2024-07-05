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
        Schema::create('pending_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->nullable();
            $table->string('rc')->nullable();
            $table->string('insurance')->nullable();
            $table->string('delivery_document')->nullable();
            $table->string('key')->nullable();
            $table->string('pancard')->nullable();
            $table->string('aadharcard')->nullable();
            $table->string('photograph')->nullable();
            $table->string('transfer_set')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_documents');
    }
};
