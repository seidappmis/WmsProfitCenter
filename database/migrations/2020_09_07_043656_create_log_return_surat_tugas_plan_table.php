<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogReturnSuratTugasPlanTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('log_return_surat_tugas_plan', function (Blueprint $table) {
      $table->bigInteger('id_detail_plan');
      $table->bigInteger('id_header');
      $table->string('area', 20)->nullable();
      $table->date('date')->nullable();
      $table->string('no', 40)->nullable();
      $table->string('no_document', 40)->nullable();
      $table->string('costumer_po', 40)->nullable();
      $table->string('expedition_code', 20)->nullable();
      $table->string('expedition', 100)->nullable();
      $table->string('vehicle_no', 20)->nullable();
      $table->string('driver', 100)->nullable();
      $table->string('model', 20)->nullable();
      $table->string('model_description', 100)->nullable();
      $table->integer('qty')->nullable();
      $table->decimal('cbm', 18, 3)->nullable();
      $table->string('description', 100)->nullable();
      $table->string('costumer_code', 20)->nullable();
      $table->string('costumer_name', 100)->nullable();
      $table->string('location', 40)->nullable();
      $table->string('document', 100)->nullable();
      $table->date('return_date')->nullable();
      $table->integer('lead_time')->nullable();
      $table->string('no_so', 40)->nullable();
      $table->string('category', 40)->nullable();
      $table->string('no_app', 40)->nullable();
      $table->string('no_do', 40)->nullable();
      $table->string('remark', 100)->nullable();
      $table->datetime('upload_date')->nullable();
      $table->bigInteger('upload_by')->nullable();
      $table->string('allocation', 40)->nullable();
      $table->string('admin_warehouse', 40)->nullable();
      $table->string('security', 40)->nullable();
      $table->string('checker', 40)->nullable();
      $table->string('wh', 40)->nullable();
      $table->string('driver_print', 40)->nullable();

      $table->primary('id_detail_plan');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('log_return_surat_tugas_plan');
  }
}
