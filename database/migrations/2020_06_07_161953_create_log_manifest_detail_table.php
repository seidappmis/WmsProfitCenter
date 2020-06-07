<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogManifestDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_manifest_detail', function (Blueprint $table) {
      $table->id();
      $table->string('do_manifest_no', 50);
      $table->integer('no_urut')->nullable();
      $table->string('delivery_no', 50)->nullable();
      $table->integer('delivery_items')->nullable();
      $table->string('invoice_no', 50)->nullable();
      $table->integer('line_no')->nullable();
      $table->tinyInteger('ambil_sendiri')->nullable();
      $table->string('model', 50)->nullable();
      $table->string('expedition_code', 50)->nullable();
      $table->string('expedition_name', 50)->nullable();
      $table->string('sold_to', 50)->nullable();
      $table->string('sold_to_code', 50)->nullable();
      $table->string('sold_to_street', 50)->nullable();
      $table->string('ship_to', 50)->nullable();
      $table->string('ship_to_code', 50)->nullable();
      $table->string('city_code', 50)->nullable();
      $table->string('city_name', 50)->nullable();
      $table->string('do_date', 50)->nullable();
      $table->integer('quantity')->nullable();
      $table->decimal('cbm', 18, 3)->nullable();
      $table->string('area', 50)->nullable();
      $table->string('do_internal', 50)->nullable();
      $table->string('reservasi_no', 50)->nullable();
      $table->decimal('nilai_ritase', 18, 3);
      $table->decimal('nilai_ritase2', 18, 3);
      $table->decimal('nilai_cbm', 18, 3);
      $table->string('code_sales', 50)->nullable();
      $table->tinyInteger('tcs')->nullable();
      $table->decimal('multidro', 18, 3)->nullable();
      $table->decimal('unloading', 18, 3)->nullable();
      $table->decimal('overstay', 18, 3)->nullable();
      $table->tinyInteger('do_return');
      $table->tinyInteger('status_confirm');
      $table->datetime('confirm_date')->nullable();
      $table->string('confirm_by', 50)->nullable();
      $table->integer('lead_time');
      $table->decimal('base_price', 18, 3)->nullable();
      $table->string('kode_cabang', 50)->nullable();
      $table->string('region', 50)->nullable();
      $table->string('remarks', 50)->nullable();
      $table->datetime('actual_time_arrival')->nullable();
      $table->datetime('actual_loading_date')->nullable();
      $table->datetime('doc_do_return_date')->nullable();
      $table->tinyInteger('status_ds_done');
      $table->tinyInteger('do_reject');
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
    Schema::dropIfExists('log_manifest_detail');
  }
}
