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
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('state_id')->nullable()->default(1);
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('state_id')->nullable()->default(1);
        });

        Schema::table('sale_details', function (Blueprint $table) {
            $table->string('state_id')->nullable()->default(1);
        });

        Schema::table('sale_orders', function (Blueprint $table) {
            $table->string('state_id')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
};
