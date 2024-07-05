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
            $table->date('dob_date')->nullable();
            $table->date('login_date')->nullable();
            $table->date('disbursed_date')->nullable();
            $table->string('co_applicant')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
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
