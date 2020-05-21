<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsBranchExpeditionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_branch_expedition', function (Blueprint $table) {
      $table->id();
      $table->string('initial', 50);
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
      $table->string('kode_cabang', 2);
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
    Schema::dropIfExists('wms_branch_expedition');
  }
}
