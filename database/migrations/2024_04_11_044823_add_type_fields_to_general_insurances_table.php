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
            $table->string('type_1')->nullable();
            $table->string('type_2')->nullable();
            $table->string('type_3')->nullable();
            $table->string('type_4')->nullable();
            $table->string('type_total')->nullable();
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
