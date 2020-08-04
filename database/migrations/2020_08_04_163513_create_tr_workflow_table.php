<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrWorkflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_workflow', function (Blueprint $table) {
            $table->id(); // PK
            $table->integer('step_number');
            $table->string('step_description', 100)->nullable();
            $table->string('step_condition_explanation', 150)->nullable();
            $table->boolean('finished')->nullable();
            $table->string('formname')->nullable(); // nvarchar max
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_workflow');
    }
}
