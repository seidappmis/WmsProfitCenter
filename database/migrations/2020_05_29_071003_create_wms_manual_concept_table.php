<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsManualConceptTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_manual_concept', function (Blueprint $table) {
      $table->string('invoice_no', 10);
      $table->string('delivery_no', 10);
      $table->integer('delivery_items');
      $table->string('do_date', 12)->nullable();
      $table->string('kode_customer', 8)->nullable();
      $table->string('long_description_customer', 100)->nullable();
      $table->string('model', 50);
      $table->string('ean_code', 50)->nullable();
      $table->integer('quantity');
      $table->decimal('cbm', 18, 3);
      $table->string('code_sales', 2)->nullable();
      $table->string('area', 20)->nullable();
      $table->string('kode_cabang', 2)->nullable();
      $table->datetime('split_date', 2)->nullable();
      $table->integer('split_by')->nullable();
      $table->string('remarks', 200);

      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary(['invoice_no', 'delivery_no', 'delivery_items']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_manual_concept');
  }
}
