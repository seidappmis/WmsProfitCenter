<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsBranchDriverTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_branch_driver', function (Blueprint $table) {
      $table->string('driver_id', 10);
      $table->string('driver_name', 100)->nullable();
      $table->string('expedition_code', 3)->nullable();
      $table->string('driving_lisence_type', 50)->nullable();
      $table->string('driving_lisence_no', 50);
      $table->string('ktp_no', 50)->nullable();
      $table->string('phone1', 16)->nullable();
      $table->string('phone2', 16)->nullable();
      $table->string('photo_name', 100)->nullable();
      $table->string('remarks1', 100)->nullable();
      $table->string('remarks2', 100)->nullable();
      $table->string('remarks3', 100)->nullable();
      $table->tinyInteger('active_status')->nullable();
      $table->string('kode_cabang', 20)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('driver_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_branch_driver');
  }
}
