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
            $table->bigInteger('contact_number')->nullable()->after('profile_image');
            $table->tinyInteger('gender')->default(1)->after('contact_number');
            $table->string('address')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_logins', function (Blueprint $table) {
            $table->dropColumn('contact_number');
            $table->dropColumn('gender');
            $table->dropColumn('address');
        });
    }
};
