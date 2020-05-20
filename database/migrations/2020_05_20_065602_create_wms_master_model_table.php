<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsMasterModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_master_model', function (Blueprint $table) {
            $table->id();
            $table->string('model_name', 50)->nullable();
            $table->string('ean_code', 50)->nullable();
            $table->decimal('cbm', 8, 2)->nullable();
            $table->string('material_group', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('model_type', 10)->nullable();
            $table->integer('pcs_ctn')->nullable();
            $table->integer('ctn_plt')->nullable();
            $table->integer('max_pallet')->nullable();
            $table->string('description', 250)->nullable();
            $table->integer('price1')->nullable();
            $table->integer('price2')->nullable();
            $table->integer('price3')->nullable();

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
        Schema::dropIfExists('wms_master_model');
    }
}
