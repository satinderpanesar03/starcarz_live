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
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->string('premium')->nullable();
            $table->string('gst')->nullable();
            $table->string('gross_premium')->nullable();
            $table->date('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_insurances', function (Blueprint $table) {
            //
        });
    }
};
