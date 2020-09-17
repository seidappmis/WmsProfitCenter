<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsUsersGrantCabangTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('wms_users_grant_cabang', function (Blueprint $table) {
      $table->string('userid', 50);
      $table->string('kode_cabang_grant', 2);
      $table->timestamps();

      $table->primary(['userid', 'kode_cabang_grant']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('wms_users_grant_cabang');
  }
}
