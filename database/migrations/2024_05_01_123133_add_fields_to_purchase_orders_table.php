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
        Schema::table('purchases', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['mst_executive_id']);
            $table->dropForeign(['mst_party_id']);
            $table->dropForeign(['mst_brand_type_id']);
            $table->dropForeign(['mst_model_id']);
            $table->dropForeign(['mst_color_id']);

            // Drop columns
            $table->dropColumn('mst_executive_id');
            $table->dropColumn('mst_party_id');
            $table->dropColumn('mst_brand_type_id');
            $table->dropColumn('mst_model_id');
            $table->dropColumn('mst_color_id');
        });

        Schema::table('purchases', function (Blueprint $table) {
            // Add new columns
            $table->unsignedBigInteger('mst_executive_id')->nullable()->after('enquiry_id');
            $table->unsignedBigInteger('mst_party_id')->nullable()->after('mst_executive_id');
            $table->unsignedBigInteger('mst_brand_type_id')->nullable()->after('mst_party_id');
            $table->unsignedBigInteger('mst_model_id')->nullable()->after('mst_brand_type_id');
            $table->unsignedBigInteger('mst_color_id')->nullable()->after('mst_model_id');
            $table->string('firm_name')->nullable()->after('mst_party_id');
            $table->string('follow_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
};
