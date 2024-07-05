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
            $table->string('executive')->nullable()->after('approved_amount');
            $table->string('loan_amount')->nullable();
            $table->string('tenure')->nullable();
            $table->integer('emi_amount')->nullable();
            $table->integer('emi_advance')->nullable();
            $table->date('emi_start_date')->nullable();
            $table->date('emi_end_date')->nullable();
        });

        Schema::table('mortage_loans', function (Blueprint $table) {
            $table->string('executive')->nullable()->after('approved_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_loans', function (Blueprint $table) {
            $table->dropColumn('executive');
            $table->dropColumn('loan_amount');
            $table->dropColumn('tenure');
            $table->dropColumn('emi_amount');
            $table->dropColumn('emi_advance');
            $table->dropColumn('emi_start_date');
            $table->dropColumn('emi_end_date');
        });

        Schema::table('mortage_loans', function (Blueprint $table) {
            $table->dropColumn('executive');
        });
    }
};
