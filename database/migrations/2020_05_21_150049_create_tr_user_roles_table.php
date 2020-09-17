<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrUserRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tr_user_roles', function (Blueprint $table) {
      $table->string('roles_id', 150);
      $table->string('roles_name', 100);
      $table->timestamps();

      $table->primary('roles_id'); // add primary key
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tr_user_roles');
  }
}
