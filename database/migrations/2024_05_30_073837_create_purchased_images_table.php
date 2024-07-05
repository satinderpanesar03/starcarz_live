<?php

use App\Models\Purchase;
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
        Schema::create('purchased_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class);
            $table->string('front')->nullable();
            $table->string('side')->nullable();
            $table->string('back')->nullable();
            $table->string('interior')->nullable();
            $table->string('tyre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchased_images');
    }
};
