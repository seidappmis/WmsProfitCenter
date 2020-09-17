<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_cabang', function (Blueprint $table) {
            $table->string('kode_customer', 8);
            $table->string('kode_cabang', 2);
            $table->string('short_description', 3)->nullable();
            $table->string('long_description', 100)->nullable();
            $table->string('type', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->boolean('hq')->nullable();
            $table->string('start_wms', 20)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary('kode_customer'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_cabang');
    }
}
