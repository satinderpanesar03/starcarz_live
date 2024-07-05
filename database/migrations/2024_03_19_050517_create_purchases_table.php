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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reg_number')->nullable();
            $table->foreignId('mst_executive_id')->constrained()->onDelete('restrict')->default(null);
            $table->dateTime('evaluation_date')->nullable();
            $table->foreignId('mst_party_id')->constrained()->onDelete('restrict')->default(null);
            $table->string('contact_person_name')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('registered_owner')->nullable();
            $table->foreignId('mst_brand_type_id')->constrained()->onDelete('restrict')->default(null);
            $table->foreignId('mst_model_id')->constrained()->onDelete('restrict')->default(null);
            $table->integer('manufacturing_year')->nullable();
            $table->integer('registration_year')->nullable();
            $table->integer('kilometer')->nullable();
            $table->string('expectation')->nullable();
            $table->foreignId('mst_color_id')->constrained()->onDelete('restrict')->default(null);
            $table->string('owners')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('shape_type')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chasis_number')->nullable();
            $table->string('service_booklet')->nullable();
            $table->dateTime('date_of_purchase')->nullable();
            $table->string('enquiry_type')->nullable();
            $table->string('other')->nullable();
            $table->tinyInteger('willing_insurance')->default(1);
            $table->string('tyres_condition')->nullable();
            $table->string('parts_changed')->nullable();
            $table->string('parts_repainted')->nullable();
            $table->string('service_and_oil_change')->nullable();
            $table->integer('service_and_oil_change_amount')->nullable();
            $table->string('compound_and_dry_clean')->nullable();
            $table->integer('compound_and_dry_clean_amount')->nullable();
            $table->string('paint_and_denting')->nullable();
            $table->integer('paint_and_denting_amount')->nullable();
            $table->string('electrical_and_electronics')->nullable();
            $table->integer('electrical_and_electronics_amount')->nullable();
            $table->string('engine_compartment')->nullable();
            $table->integer('engine_compartment_amount')->nullable();
            $table->string('accessories')->nullable();
            $table->integer('accessories_amount')->nullable();
            $table->string('others_desc')->nullable();
            $table->integer('others_amount')->nullable();
            $table->tinyInteger('registration_cerificate')->default(1);
            $table->tinyInteger('hypothecation')->default(1);
            $table->string('image')->nullable();
            $table->integer('expected_price')->nullable();
            $table->string('valuation')->nullable();
            $table->string('remarks')->nullable();
            $table->string('purchases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
