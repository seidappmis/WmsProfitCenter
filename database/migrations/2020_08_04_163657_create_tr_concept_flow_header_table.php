<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrConceptFlowHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_concept_flow_header', function (Blueprint $table) {
            $table->string('id', 20); // PK
            $table->integer('workflow_id')->nullable();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->string('driver_id', 10)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->integer('expedition_id')->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->decimal('cbm_truck', 18, 3)->nullable();
            $table->decimal('cbm_concept', 18, 3)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->dateTime('workflow_date')->nullable();
            $table->string('area', 20)->nullable();
            $table->string('driver_register_id', 50)->nullable();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_concept_flow_header');
    }
}
