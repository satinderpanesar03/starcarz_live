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
        Schema::table('aggregator_loans', function (Blueprint $table) {
            $table->string('disburshment_date')->after('state_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aggregator_loans', function (Blueprint $table) {
            $table->dropColumn(['disburshment_date']);
        });
    }
};
