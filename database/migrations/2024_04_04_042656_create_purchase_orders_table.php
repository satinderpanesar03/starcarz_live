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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->nullable();
            $table->foreignId('purchase_id')->nullable();
            $table->foreignId('icompany_id')->nullable();
            $table->string('ncb_insurance')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('registration_cerificate')->default(1);
            $table->tinyInteger('hypothecation')->default(1);
            $table->string('name_fcompany')->nullable();
            $table->string('loanos')->nullable();
            $table->string('image')->nullable();
            $table->integer('price_p1')->nullable();
            $table->string('price_p2')->nullable();
            $table->dateTime('reg_date')->nullable();
            $table->dateTime('insurance_due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
