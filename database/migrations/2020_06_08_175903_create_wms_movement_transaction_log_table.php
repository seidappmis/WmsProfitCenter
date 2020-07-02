<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsMovementTransactionLogTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_movement_transaction_log', function (Blueprint $table) {
      $table->string('log_id', 50);
      $table->string('arrival_no', 50)->nullable();
      $table->string('do_manifest_no', 50)->nullable();
      $table->date('lmb_date')->nullable();
      $table->string('do_reservation_no', 20)->nullable();
      $table->integer('mvt_master_id')->nullable();
      $table->string('driver_register_id', 50)->nullable();
      $table->string('inventory_movement', 50)->nullable();
      $table->string('movement_code', 10)->nullable();
      $table->string('transactions_desc', 150)->nullable();
      $table->string('storage_location_from', 10)->nullable();
      $table->string('storage_location_to', 10)->nullable();
      $table->string('storage_location_code', 23)->nullable();
      $table->string('eancode', 50)->nullable();
      $table->string('model', 100)->nullable();
      $table->integer('quantity')->nullable();
      $table->datetime('movement_date')->nullable();
      $table->string('kode_cabang', 2)->nullable();
      $table->string('cancel_log_id', 50)->nullable();
      $table->string('flow_id', 50)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('log_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_movement_transaction_log');
  }
}
