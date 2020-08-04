<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrConceptFlowDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_concept_flow_detail', function (Blueprint $table) {
            $table->string('id_header', 20); // FK
            $table->string('invoice_no', 10); // PK
            $table->integer('line_no'); // PK
            $table->integer('quantity')->nullable();
            $table->decimal('cbm_max', 18, 3)->nullable();
            $table->string('concept_type', 100)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('delivery_no', 20)->nullable();
            $table->integer('delivery_items')->nullable();
            $table->boolean('onlogsys');
            $table->boolean('overload');
            $table->string('remarks', 200)->nullable();

            $table->primary('invoice_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_concept_flow_detail');
    }
}
