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
            $table->unsignedBigInteger('mst_executive_id')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('person_name')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('budget_type')->nullable();
            $table->tinyInteger('finance_requirement')->nullable();
            $table->tinyInteger('enquiry_type')->nullable();
            $table->tinyInteger('fuel_type')->nullable();
            $table->string('follow_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_details', function (Blueprint $table) {
            //
        });
    }
};
