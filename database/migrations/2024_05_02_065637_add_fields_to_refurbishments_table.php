<?php

use App\Models\RefurbnishmentOrder;
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
        Schema::dropIfExists('refurbishments');

        Schema::create('refurbishments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RefurbnishmentOrder::class)->constrained()->onDelete('cascade');
            $table->date('voucher_date')->nullable();
            $table->unsignedBigInteger('mst_model_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->unsignedBigInteger('mst_supplier_id')->nullable();
            $table->tinyInteger('payment_mode')->nullable();
            $table->tinyInteger('head')->nullable();
            $table->unsignedBigInteger('mst_executive_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refurbishments');
    }
};
