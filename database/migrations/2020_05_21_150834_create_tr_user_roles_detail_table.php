<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrUserRolesDetailTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tr_user_roles_detail', function (Blueprint $table) {
      $table->id();
      $table->string('roles_id', 150);
      $table->integer('modul_id');
      $table->tinyInteger('view')->default(0);
      $table->tinyInteger('edit')->default(0);
      $table->tinyInteger('delete')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tr_user_roles_detail');
  }
}
