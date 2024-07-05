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
        Schema::create('mortage_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->constrained()->onDelete('restrict');
            $table->foreignId('mst_executive_id')->constrained()->onDelete('restrict');
            $table->foreignId('mst_bank_id')->constrained()->onDelete('restrict');
            $table->dateTime('disburse_date');
            $table->tinyInteger('disburse_date_status')->default(2)->comment('1=>active,2=>inactive');
            $table->integer('emi_amount')->nullable();
            $table->string('tenure')->nullable();
            $table->string('mclr')->nullable();
            $table->integer('margin')->nullable();
            $table->integer('effective_rate')->nullable();
            $table->integer('loan_number')->nullable();
            $table->integer('loan_amount')->nullable();
            $table->dateTime('emi_start_date')->nullable();
            $table->dateTime('emi_end_date')->nullable();
            $table->string('property_mortaged')->nullable();
            $table->integer('bt_loan_amount')->nullable();
            $table->integer('topup_loan_amount')->nullable();
            $table->integer('property_price')->nullable();
            $table->string('pending_documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortage_loans');
    }
};
