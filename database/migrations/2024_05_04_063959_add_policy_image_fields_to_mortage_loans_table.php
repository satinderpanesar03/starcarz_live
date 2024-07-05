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
        Schema::table('mortage_loans', function (Blueprint $table) {
            $table->date('login_date')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('tenure')->nullable();
            $table->date('status_date')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mortage_loans', function (Blueprint $table) {
            //
        });
    }
};
