<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsInventoryStorageTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_inventory_storage', function (Blueprint $table) {
      $table->id();
      $table->integer('storage_id');
      $table->string('model_name', 50)->nullable();
      $table->string('ean_code', 50)->nullable();
      $table->decimal('cbm_total', 18, 3)->nullable();
      $table->integer('quantity_total')->nullable();
      $table->datetime('last_updated')->nullable();
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
    Schema::dropIfExists('wms_inventory_storage');
  }
}
