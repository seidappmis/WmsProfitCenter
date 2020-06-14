<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsAdjustmentLogTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_adjustment_log', function (Blueprint $table) {
      $table->string('log_id', 50);
      $table->string('kode_cabang', 2);
      $table->string('sloc', 50);
      $table->string('model', 50);
      $table->integer('quantity')->nullable();
      $table->integer('prev_quantity')->nullable();
      $table->string('movement_code_type', 50)->nullable();
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
    Schema::dropIfExists('wms_adjustment_log');
  }
}
