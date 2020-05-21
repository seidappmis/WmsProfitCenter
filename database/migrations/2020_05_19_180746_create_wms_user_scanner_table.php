<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsUserScannerTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_user_scanner', function (Blueprint $table) {
      $table->string('userid', 50);
      $table->integer('roles');
      $table->tinyInteger('status_active');
      $table->timestamps();
      $table->integer('created_by');
      $table->integer('updated_by');

      $table->primary('userid');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_user_scanner');
  }
}
