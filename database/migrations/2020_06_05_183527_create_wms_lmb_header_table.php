<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsLmbHeaderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_lmb_header', function (Blueprint $table) {
      $table->string('driver_register_id', 50);
      $table->date('lmb_date');
      $table->string('do_reservation_no', 20);
      $table->string('pdo', 50)->nullable();
      $table->string('expedition_code', 3)->nullable();
      $table->string('expedition_name', 100)->nullable();
      $table->string('driver_id', 10)->nullable();
      $table->string('driver_name', 100)->nullable();
      $table->string('vehicle_number', 11)->nullable();
      $table->string('destination_number', 6)->nullable();
      $table->string('destination_name', 100)->nullable();
      $table->string('kode_cabang', 2)->nullable();
      $table->string('short_description_cabang', 3)->nullable();
      $table->string('seal_no', 20)->nullable();
      $table->string('container_no', 20)->nullable();
      $table->tinyInteger('send_manifest');
      $table->datetime('start_date')->nullable();
      $table->datetime('finish_date')->nullable();
      $table->string('finish_by', 50)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('driver_register_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_lmb_header');
  }
}
