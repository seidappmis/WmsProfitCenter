<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogReturnSuratTugasActualTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_return_surat_tugas_actual', function (Blueprint $table) {
      $table->bigInteger('id_detail_actual');
      $table->bigInteger('id_header');
      $table->bigInteger('id_detail_plan');
      $table->string('area', 20)->nullable();
      $table->date('date')->nullable();
      $table->string('no_document', 40)->nullable();
      $table->string('costumer_po', 40)->nullable();
      $table->string('model', 20)->nullable();
      $table->integer('qty')->nullable();
      $table->string('serial_number', 40)->nullable();
      $table->string('no_so', 40)->nullable();
      $table->string('no_do', 40)->nullable();
      $table->string('no_po', 40)->nullable();
      $table->string('ceck', 20)->nullable();
      $table->string('rr', 20)->nullable();
      $table->string('kondisi', 40)->nullable();
      $table->string('remark', 40)->nullable();
      $table->datetime('created_date')->nullable();
      $table->integer('created_by')->nullable();
      $table->datetime('modifiy_date')->nullable();
      $table->integer('modifiy_by')->nullable();

      $table->primary('id_detail_actual');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_return_surat_tugas_actual');
  }
}
