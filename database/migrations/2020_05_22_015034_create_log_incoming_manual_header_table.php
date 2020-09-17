<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogIncomingManualHeaderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_incoming_manual_header', function (Blueprint $table) {
      $table->string('arrival_no', 30);
      $table->string('po', 100);
      $table->string('invoice_no', 100)->nullable();
      $table->string('no_gr_sap', 100)->nullable();
      $table->date('document_date')->nullable();
      $table->string('vendor_name', 100);
      $table->date('actual_arrival_date')->nullable();
      $table->string('expedition_name', 100)->nullable();
      $table->string('container_no', 100)->nullable();
      $table->string('area', 20)->nullable();
      $table->string('inc_type', 10)->nullable();
      $table->string('kode_cabang', 2)->nullable();
      $table->tinyInteger('submit');
      $table->datetime('submit_date')->nullable();
      $table->string('submit_by', 50)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('arrival_no');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_incoming_manual_header');
  }
}
