<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogFinishGoodDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_finish_good_detail', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no_header', 50);
            $table->string('bar_ticket_header', 100);
            $table->string('model', 100);
            $table->integer('quantity');
            $table->string('print_type', 10);
            $table->string('ean_code', 50);
            $table->string('kode_cabang', 2)->nullable();
            $table->integer('storage_id')->nullable();
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
        Schema::dropIfExists('log_finish_good_detail');
    }
}
