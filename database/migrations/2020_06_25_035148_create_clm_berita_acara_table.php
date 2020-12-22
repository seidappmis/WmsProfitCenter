<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClmBeritaAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clm_berita_acara', function (Blueprint $table) {
            $table->id();
            $table->string('berita_acara_no', 20);
            $table->date('date_of_receipt')->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('driver_name', 50)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('do_manifest')->nullable();
            $table->string('internal_do')->nullable();
            $table->string('lmb')->nullable();
            $table->string('kode_cabang', 3)->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->integer('submit_by')->nullable();
            $table->datetime('submit_date')->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            // $table->primary('berita_acara_id'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clm_berita_acara');
    }
}
