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
        Schema::table('mst_rto_agents', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('phone_number')->nullable();
            $table->tinyInteger('status')->comment('1=>active,2=>deactive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_rto_agents', function (Blueprint $table) {
            //
        });
    }
};
