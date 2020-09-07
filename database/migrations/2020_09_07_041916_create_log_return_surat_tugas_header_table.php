<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogReturnSuratTugasHeaderTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_return_surat_tugas_header', function (Blueprint $table) {
      $table->bigInteger('id_header')->autoIncrement();
      $table->string('area', 20)->nullable();
      $table->date('date')->nullable();
      $table->string('no_document', 40)->nullable();
      $table->string('customer_po', 40)->nullable();
      $table->datetime('upload_date')->nullable();
      $table->integer('upload_by')->nullable();

      // $table->primary('id_header');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_return_surat_tugas_header');
  }
}
