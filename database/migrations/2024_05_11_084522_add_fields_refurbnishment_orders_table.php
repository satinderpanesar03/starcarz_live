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
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('executive_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('head')->nullable();
            $table->string('description')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refurbnishment_orders', function (Blueprint $table) {
            $table->dropColumn('model_id');
            $table->dropColumn('executive_id');
            $table->dropColumn('supplier_id');
            $table->dropColumn('head');
            $table->dropColumn('description');
            $table->dropColumn('date');
        });
    }
};
