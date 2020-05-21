<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('username', 50)->unique(); // UserId di aplikasi lama
      $table->string('first_name')->nullable();
      $table->string('last_name')->nullable();
      $table->string('password');
      $table->foreignId('roles_id');
      $table->tinyInteger('status')->default(1);
      $table->string('area', 20)->nullable();
      $table->string('kode_customer', 150)->nullable();
      $table->string('created_by', 150)->nullable();
      // $table->timestamp('email_verified_at')->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('users');
  }
}
