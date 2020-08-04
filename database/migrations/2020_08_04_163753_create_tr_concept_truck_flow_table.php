<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrConceptTruckFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_concept_truck_flow', function (Blueprint $table) {
            $table->string('id', 20); // PK
            $table->string('concept_flow_header', 20); // FK
            $table->integer('gate_number')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('complete_date')->nullable();
            $table->string('do_manifest_no', 20)->nullable();
            $table->dateTime('created_gate_date')->nullable();
            $table->string('created_gate_by', 50)->nullable();
            $table->dateTime('created_start_date')->nullable();
            $table->string('created_start_by', 50)->nullable();
            $table->dateTime('created_complete_date')->nullable();
            $table->string('created_complete_by', 50)->nullable();
            $table->string('area', 20)->nullable();
            $table->dateTime('created_end_date')->nullable();
            $table->string('created_end_by', 50)->nullable();

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
        Schema::dropIfExists('tr_concept_truck_flow');
    }
}
