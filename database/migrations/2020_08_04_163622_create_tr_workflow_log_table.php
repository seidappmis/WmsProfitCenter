<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrWorkflowLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_workflow_log', function (Blueprint $table) {
            $table->dateTime('id'); // PK
            $table->string('invoice_no', 10)->nullable();
            $table->integer('line_no')->nullable();
            $table->integer('step_number')->nullable();
            $table->bigInteger('created_by')->nullable();
            // $table->string('created_by', 50)->nullable();

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
        Schema::dropIfExists('tr_workflow_log');
    }
}
