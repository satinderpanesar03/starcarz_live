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
        Schema::dropIfExists('mortage_loans');

        Schema::create('mortage_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mst_party_id')->nullable();
            $table->tinyInteger('loan_type')->nullable();
            $table->tinyInteger('insurance_type')->nullable();
            $table->string('mclr')->nullable();
            $table->string('margin')->nullable();
            $table->string('effective_rate')->nullable();
            $table->string('pending_documents')->nullable();
            $table->string('sanction_letter')->nullable();
            $table->string('status')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_amount')->nullable();
            $table->string('state_id')->nullable()->default(1);
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
