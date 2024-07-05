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
        Schema::table('mst_executives', function (Blueprint $table) {
            $table->foreignId('admin_login_id')->after('name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_executives', function (Blueprint $table) {
            $table->dropColumn(['admin_login_id']);
        });
    }
};
