<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurBeritaAcaraDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dur_berita_acara_detail', function (Blueprint $table) {
            $table->id();

            $table->integer('berita_acara_during_id')->length(20)->nullable();
            $table->string('model_name', 50)->nullable();
            $table->integer('qty')->length(11)->nullable();
            $table->string('pom')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('damage')->nullable();
            $table->string('photo_serial_number')->nullable();
            $table->string('photo_damage')->nullable();

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
        Schema::dropIfExists('dur_berita_acara_detail');
    }
}
