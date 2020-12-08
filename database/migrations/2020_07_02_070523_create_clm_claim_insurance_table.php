<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClmClaimInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clm_claim_insurance', function (Blueprint $table) {
            $table->id();
            $table->string('claim_report')->nullable();
            $table->string('keterangan_kejadian')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('branch')->nullable();
            $table->date('date_of_loss')->nullable();
            $table->date('submit_date')->nullable();
            $table->integer('submit_by')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('remark')->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clm_claim_insurance');
    }
}
