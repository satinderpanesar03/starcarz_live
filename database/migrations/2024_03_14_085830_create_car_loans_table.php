<?php

use App\Models\MstParty;
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
        Schema::create('car_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mst_party_id')->constrained()->onDelete('restrict');
            $table->string('article_flag', 65);
            $table->foreignId('mst_dealer_id')->constrained()->onDelete('restrict');
            $table->tinyInteger('status')->default(1)->comment('1=>pending,2=>approved,3=>disapproved');
            $table->dateTime('status_date');
            $table->dateTime('login_date');
            $table->dateTime('dob_date');
            $table->string('joint_name', 65);
            $table->integer('loan_amount');
            $table->integer('tenure');
            $table->foreignId('mst_model_id')->constrained()->onDelete('restrict');
            $table->foreignId('mst_executive_id')->constrained()->onDelete('restrict');
            $table->foreignId('mst_bank_id')->constrained()->onDelete('restrict');
            $table->integer('car_price');
            $table->integer('reg_number');
            $table->integer('manufacturing_year');
            $table->dateTime('disburse_date');
            $table->tinyInteger('disburse_date_status')->default(2)->comment('1=>active,2=>inactive');
            $table->integer('emi_amount');
            $table->integer('emi_advance');
            $table->dateTime('emi_start_date');
            $table->dateTime('emi_end_date');
            $table->string('bank_ipr');
            $table->integer('loan_number');
            $table->string('pending_documents')->nullable();
            $table->string('subvention');
            $table->string('sdsa_subvention')->nullable();
            $table->string('dealer_lifting')->nullable();
            $table->dateTime('registration_date');
            $table->dateTime('insruance_date_from');
            $table->dateTime('insruance_date_to');
            $table->foreignId('mst_insurance_id')->constrained()->onDelete('restrict');
            $table->string('ncb')->nullable();
            $table->string('coverage')->nullable();
            $table->string('od_premium');
            $table->string('tp_premium');
            $table->integer('gst')->nullable();
            $table->string('others')->nullable();
            $table->integer('gross_premium');
            $table->integer('sum_assured');
            $table->string('insured_by');
            $table->integer('policy_number');
            $table->dateTime('insurance_done_date');
            $table->foreignId('mst_broker_id')->constrained()->onDelete('restrict');
            $table->text('coverage_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_loans');
    }
};
