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
        Schema::table('general_insurances', function (Blueprint $table) {
            $table->string('building')->nullable();
            $table->string('plant_machinery')->nullable();
            $table->string('stock')->nullable();
            $table->string('electical')->nullable();
            $table->string('furniture')->nullable();
            $table->string('other')->nullable();
            $table->string('total_sum')->nullable();

            $table->dropColumn('type_1');
            $table->dropColumn('type_2');
            $table->dropColumn('type_3');
            $table->dropColumn('type_4');
            $table->dropColumn('type_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_insurances', function (Blueprint $table) {
            //
        });
    }
};
