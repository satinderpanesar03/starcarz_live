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
        Schema::table('rc_transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_order_id')->nullable();
            $table->unsignedBigInteger('aggregator_loan_id')->nullable();
            $table->unsignedBigInteger('car_loan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rc_transfers', function (Blueprint $table) {
            $table->dropColumn('sale_order_id');
            $table->dropColumn('aggregator_loan_id');
            $table->dropColumn('car_loan_id');
        });
    }
};
