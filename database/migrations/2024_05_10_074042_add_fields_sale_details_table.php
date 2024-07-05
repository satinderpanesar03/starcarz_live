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
        Schema::table('sale_details', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
        });
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->date('insurance_done_date')->nullable();
            $table->date('insurance_from_date')->nullable();
            $table->date('insurance_to_date')->nullable();
            $table->string('kilometer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropColumn('brand');
            $table->dropColumn('color');
            $table->dropColumn('model');
        });

        Schema::table('sale_orders', function (Blueprint $table) {
            $table->dropColumn('brand_id');
            $table->dropColumn('model_id');
            $table->dropColumn('insurance_done_date');
            $table->dropColumn('insurance_from_date');
            $table->dropColumn('insurance_to_date');
            $table->dropColumn('kilometer');
        });
    }
};
