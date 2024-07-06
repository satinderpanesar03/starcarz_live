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
        Schema::table('admin_logins', function (Blueprint $table) {
            $table->tinyInteger('all_access')->nullable()->comment('1=>yes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_logins', function (Blueprint $table) {
            $table->dropColumn(['all_access']);
        });
    }
};
