<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurBeritaAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dur_berita_acara', function (Blueprint $table) {
            $table->id();

            $table->string('berita_acara_during_no', 30)->nullable();
            $table->date('tanggal_berita_acara')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->string('category_damage')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('container_no')->nullable();
            $table->string('bl_no')->nullable();
            $table->string('seal_no')->nullable();
            $table->string('damage_type')->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('weather')->nullable();
            $table->string('working_hour')->nullable();
            $table->string('location')->nullable();
            $table->string('photo_container_came')->nullable();
            $table->string('photo_container_loading')->nullable();
            $table->string('photo_seal_no')->nullable();
            $table->string('photo_loading')->nullable();
            $table->integer('submit_by')->nullable();
            $table->datetime('submit_date')->nullable();

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
        Schema::dropIfExists('dur_berita_acara');
    }
}
