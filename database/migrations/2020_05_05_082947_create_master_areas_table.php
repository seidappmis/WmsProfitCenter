<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_areas', function (Blueprint $table) {
            // $table->id();
            $table->string('code', 10);
            $table->string('area', 100)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary('code'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_areas');
    }
}
