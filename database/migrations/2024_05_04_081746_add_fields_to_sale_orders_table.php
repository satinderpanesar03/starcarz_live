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
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->string('buyer_id_image')->nullable();
            $table->string('pancard_image')->nullable();
            $table->string('pancard_number')->nullable();
            $table->string('aadharcard_number')->nullable();
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('pancard_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            //
        });
    }
};
