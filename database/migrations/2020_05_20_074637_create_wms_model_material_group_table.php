<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsModelMaterialGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_model_material_group', function (Blueprint $table) {
            // $table->id();
            $table->string('code', 100);
            $table->string('description', 250)->nullable();
            $table->string('business_unit', 5)->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('wms_model_material_group');
    }
}
