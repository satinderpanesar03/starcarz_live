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
        Schema::table('car_insurances', function (Blueprint $table) {
            $table->tinyInteger('vehicle_type')->comment('1=>bike, 2=>car')->default(null);
            $table->tinyInteger('od_type_insurance')->comment('1=>od, 2=>compre,others')->default(null);
            $table->string('normal')->default('NA');
            $table->string('zero_dep')->default('NA');
            $table->string('consumables')->default('NA');
            $table->string('engine')->default('NA');
            $table->string('tyre')->default('NA');
            $table->string('rti')->default('NA');
            $table->string('ncb_protection')->default('NA');
            $table->string('key')->default('NA');
            $table->string('rsa')->default('NA');
            $table->string('lob')->default('NA');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_insurances', function (Blueprint $table) {
            //
        });
    }
};
