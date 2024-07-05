<?php

use App\Models\MortageLoan;
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
        Schema::create('mortage_disbursed_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MortageLoan::class)->constrained()->onDelete('cascade');
            $table->string('loan_number')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('tenure')->nullable();
            $table->integer('emi_amount')->nullable();
            $table->integer('emi_advance')->nullable();
            $table->date('emi_start_date')->nullable();
            $table->date('emi_end_date')->nullable();
            $table->string('disbursed_amount')->nullable();
            $table->date('disbursed_date')->nullable();
            $table->string('roi')->nullable();
            $table->string('co_applicant')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortage_disbursed_details');
    }
};
