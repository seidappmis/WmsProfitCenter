<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogIncomingManualDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_incoming_manual_detail', function (Blueprint $table) {
      $table->id();
      $table->string('arrival_no_header', 30);
      $table->string('model', 50);
      $table->string('description', 100)->nullable();
      $table->integer('qty')->nullable();
      $table->decimal('cbm', 18, 3)->nullable();
      $table->decimal('total_cbm', 18, 3)->nullable();
      $table->string('no_gr_sap', 50)->nullable();
      $table->string('kode_cabang', 2)->nullable();
      $table->integer('storage_id')->nullable();
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
    Schema::dropIfExists('log_incoming_manual_detail');
  }
}
