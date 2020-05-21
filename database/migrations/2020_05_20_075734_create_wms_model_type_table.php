<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsModelTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_model_type', function (Blueprint $table) {
            // $table->id();
            $table->string('model_type', 10);
            $table->string('model_type_desc', 250)->nullable();

            $table->timestamps();

            $table->primary('model_type'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wms_model_type');
    }
}
