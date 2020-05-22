<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterExpeditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_expedition', function (Blueprint $table) {
            $table->id();
            $table->string('expedition_name', 100)->nullable();
            $table->string('npwp', 20)->nullable();
            $table->string('code', 52);
            $table->string('address', 200)->nullable();
            $table->string('sap_vendor_code', 200)->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('phone_number_1', 16)->nullable();
            $table->string('phone_number_2', 16)->nullable();
            $table->string('fax_number', 16)->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('remark1', 100)->nullable();
            $table->string('remark2', 100)->nullable();
            $table->string('remark3', 100)->nullable();
            $table->tinyInteger('status_active')->nullable();
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
        Schema::dropIfExists('master_expedition');
    }
}
