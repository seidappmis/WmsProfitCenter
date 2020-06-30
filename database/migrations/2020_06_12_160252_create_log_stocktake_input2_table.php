<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStocktakeInput2Table extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_stocktake_input2', function (Blueprint $table) {
      $table->id();
      $table->string('sto_id', 18)->nullable();
      $table->integer('no_tag')->nullable();
      $table->string('model', 20)->nullable();
      $table->string('quantity')->nullable();
      $table->string('location', 20)->nullable();
      $table->integer('upload_by')->nullable();
      $table->integer('input_by')->nullable();
      $table->datetime('upload_date')->nullable();
      $table->datetime('input_date')->nullable();

      // $table->timestamps();
      // $table->integer('created_by')->nullable();
      // $table->integer('updated_by')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_stocktake_input2');
  }
}
