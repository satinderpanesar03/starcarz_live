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
        Schema::table('refurbnishment_orders', function (Blueprint $table) {
            $table->dropColumn('refurbnishment_date');
            $table->date('service_date')->nullable();
            $table->date('compound_date')->nullable();
            $table->date('paint_date')->nullable();
            $table->date('electrical_date')->nullable();
            $table->date('engine_date')->nullable();
            $table->date('accessories_date')->nullable();
            $table->date('others_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refurbnishment_orders', function (Blueprint $table) {
            //
        });
    }
};
