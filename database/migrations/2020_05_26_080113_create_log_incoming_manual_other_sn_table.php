<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogIncomingManualOtherSnTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_incoming_manual_other_sn', function (Blueprint $table) {
      $table->foreignId('manual_id');
      $table->string('serialnumber', 50);
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary(['manual_id', 'serialnumber']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_incoming_manual_other_sn');
  }
}
