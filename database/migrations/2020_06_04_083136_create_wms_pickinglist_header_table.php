<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsPickinglistHeaderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_pickinglist_header', function (Blueprint $table) {
      $table->string('id', 20);
      $table->date('picking_date')->nullable();
      $table->string('picking_no', 50)->nullable();
      $table->string('driver_register_id', 50)->nullable();
      $table->string('driver_id', 10)->nullable();
      $table->string('driver_name', 100)->nullable();
      $table->string('vehicle_number', 11)->nullable();
      $table->string('expedition_code', 3)->nullable();
      $table->string('expedition_name', 100)->nullable();
      $table->string('area', 20)->nullable();
      $table->integer('gate_number')->nullable();
      $table->string('pdo', 50)->nullable();
      $table->string('destination_number', 6)->nullable();
      $table->string('destination_name', 100)->nullable();
      $table->integer('picking_urut_no')->nullable();
      $table->tinyInteger('HQ');
      $table->string('kode_cabang', 8)->nullable();
      $table->string('vehicle_code_type', 6)->nullable();
      $table->string('city_code', 10)->nullable();
      $table->string('city_name', 100)->nullable();
      $table->integer('storage_id')->nullable();
      $table->string('storage_type', 100)->nullable();
      $table->datetime('start_date')->nullable();
      $table->string('start_by', 50)->nullable();
      $table->datetime('finish_date')->nullable();
      $table->string('finish_by', 50)->nullable();
      $table->datetime('assign_driver_date')->nullable();
      $table->string('assign_driver_by', 50)->nullable();
      $table->datetime('start_picking_date')->nullable();

      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_pickinglist_header');
  }
}
