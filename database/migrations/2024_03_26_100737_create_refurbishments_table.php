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
        Schema::create('refurbishments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('voucher_date')->nullable();
            $table->foreignId('mst_model_id')->constrained()->onDelete('restrict');
            $table->string('registration_number')->nullable();
            $table->foreignId('mst_supplier_id')->constrained()->onDelete('restrict');
            $table->tinyInteger('payment_mode')->default(1);
            $table->tinyInteger('head')->default(1);
            $table->foreignId('mst_executive_id')->constrained()->onDelete('restrict');
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refurbishments');
    }
};
