<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_type_details', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_code_type', 45)->nullable();
            $table->string('vehicle_desription', 100)->nullable();
            $table->integer('vehicle_group_id')->nullable();
            $table->decimal('cbm_min', 8, 2)->nullable();
            $table->decimal('cbm_max', 8, 2)->nullable();
            $table->string('sap_description', 100)->nullable();
            $table->string('vehicle_merk', 100)->nullable();
            $table->integer('urut')->nullable();
            
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
        Schema::dropIfExists('vehicle_type_details');
    }
}
