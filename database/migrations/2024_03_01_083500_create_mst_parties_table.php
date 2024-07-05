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
        Schema::create('mst_parties', function (Blueprint $table) {
            $table->id();
            $table->string('party_name')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('whatsapp_number')->nullable();
            $table->bigInteger('office_number')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_city')->nullable();
            $table->bigInteger('residence_number')->nullable();
            $table->string('residence_address')->nullable();
            $table->string('residence_city')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('designation')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('status')->comment('1=>accepted,2=>rejected')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_parties');
    }
};
