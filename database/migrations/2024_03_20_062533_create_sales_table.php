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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->dateTime('enquiry_date')->nullable();
            $table->foreignId('mst_executive_id')->constrained()->onDelete('restrict');
            $table->string('firm_name')->nullable();
            $table->string('person_name')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('mst_model_id')->constrained()->onDelete('restrict');
            $table->tinyInteger('budget_type')->default(1);
            $table->tinyInteger('fuel_type')->default(1);
            $table->tinyInteger('finance_requirement')->default(1);
            $table->tinyInteger('enquiry_type')->default(1);
            $table->string('remarks')->nullable();
            $table->dateTime('followup_date')->nullable();
            $table->dateTime('next_follow_date')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
