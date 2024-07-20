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
            $table->string('insurance_done_date')->after('sum_assured')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('health_insurances', function (Blueprint $table) {
            $table->dropColumn(['insurance_done_date']);
        });
    }
};
