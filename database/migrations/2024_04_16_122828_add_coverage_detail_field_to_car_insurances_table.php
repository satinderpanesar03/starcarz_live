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
            $table->string('coverage_detail')->nullable()->after('insurance_documents');
            $table->string('total')->nullable()->after('coverage_detail');
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
