<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogFinishGoodHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_finish_good_header', function (Blueprint $table) {
            $table->string('receipt_no', 50);
            $table->string('warehouse', 50);
            $table->string('supplier', 20);
            $table->string('area', 20);
            $table->string('kode_cabang', 2)->nullable();
            $table->tinyInteger('submit');
            $table->datetime('submit_date')->nullable();
            $table->string('submit_by', 50)->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary('receipt_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_finish_good_header');
    }
}
