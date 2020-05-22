<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrDriverRegisteredTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tr_driver_registered', function (Blueprint $table) {
      $table->string('id', 50);
      $table->string('driver_id', 10);
      $table->string('driver_name', 100);
      $table->string('expedition_code', 3);
      $table->string('expedition_name', 100)->nullable();
      $table->string('vehicle_number', 11)->nullable();
      $table->string('vehicle_code_type', 6);
      $table->string('vehicle_description', 150)->nullable();
      $table->string('destination_number', 6);
      $table->string('destination_name', 100)->nullable();
      $table->string('region', 100)->nullable();
      $table->string('area', 20);
      $table->datetime('datetime_in')->nullable();
      $table->datetime('datetime_out')->nullable();
      $table->string('wk_step_number', 50)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary('id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tr_driver_registered');
  }
}
