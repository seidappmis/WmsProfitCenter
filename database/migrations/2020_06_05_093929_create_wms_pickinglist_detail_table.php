<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsPickinglistDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_pickinglist_detail', function (Blueprint $table) {
      $table->string('id', 20);
      $table->string('header_id', 20)->nullable();
      $table->string('invoice_no', 20)->nullable();
      $table->integer('line_no')->nullable();
      $table->string('delivery_no', 20)->nullable();
      $table->integer('delivery_items')->nullable();
      $table->string('model', 50)->nullable();
      $table->integer('quantity')->nullable();
      $table->decimal('cbm', 18, 3)->nullable();
      $table->string('ean_code', 50)->nullable();
      $table->string('code_sales', 2)->nullable();
      $table->string('remarks', 200)->nullable();
      $table->string('kode_customer', 8)->nullable();
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
    Schema::dropIfExists('wms_pickinglist_detail');
  }
}
