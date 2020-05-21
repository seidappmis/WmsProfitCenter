<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabangs', function (Blueprint $table) {
            // $table->id();
            $table->string('kode_customer', 8);
            $table->string('kode_cabang', 2);
            $table->string('short_description', 3)->nullable();
            $table->string('long_description', 100)->nullable();
            $table->string('type', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->boolean('hq')->nullable();

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
        Schema::dropIfExists('cabangs');
    }
}
