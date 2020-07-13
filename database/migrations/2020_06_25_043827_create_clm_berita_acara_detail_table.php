<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClmBeritaAcaraDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clm_berita_acara_detail', function (Blueprint $table) {
            $table->id();
            $table->string('berita_acara_no', 20);
            $table->integer('berita_acara_id')->nullable();
            $table->string('do_no', 15)->nullable();
            $table->string('model_name', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->string('qty')->nullable();
            $table->string('description')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('keterangan')->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clm_berita_acara_detail');
    }
}
