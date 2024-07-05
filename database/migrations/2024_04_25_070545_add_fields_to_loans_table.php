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
        Schema::table('car_loans', function (Blueprint $table) {
            $table->string('disbursed_amount')->nullable();
            $table->string('roi')->nullable();
            $table->string('loan_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_loans', function (Blueprint $table) {
            //
        });
    }
};
