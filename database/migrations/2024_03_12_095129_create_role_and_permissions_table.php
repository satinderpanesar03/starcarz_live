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
        Schema::create('role_and_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Role::class);
            // $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Permission::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_and_permissions');
    }
};
