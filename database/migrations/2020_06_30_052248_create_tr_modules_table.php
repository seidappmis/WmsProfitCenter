<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrModulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tr_modules', function (Blueprint $table) {
      $table->id();
      $table->string('modul_name', 255);
      $table->string('modul_link', 255);
      $table->string('group_name', 255);
      $table->integer('order_menu');
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
    Schema::dropIfExists('tr_modules');
  }
}
