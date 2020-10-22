<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsLmbDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_lmb_detail', function (Blueprint $table) {
      $table->string('serial_number', 50);
      $table->string('delivery_no', 20);
      $table->string('model', 50);
      $table->integer('delivery_items')->nullable();
      $table->string('invoice_no', 10)->nullable();
      $table->string('ean_code', 50)->nullable();
      $table->decimal('cbm_unit', 18, 3)->nullable();
      $table->string('driver_register_id', 50)->nullable();
      $table->string('picking_id', 20)->nullable();
      $table->string('city_code', 10)->nullable();
      $table->string('city_name', 100)->nullable();
      $table->string('kode_customer', 8)->nullable();
      $table->string('code_sales', 2)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary(['serial_number', 'delivery_no', 'model']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_lmb_detail');
  }
}
