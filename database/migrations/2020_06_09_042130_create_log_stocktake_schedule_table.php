<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStocktakeScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_stocktake_schedule', function (Blueprint $table) {
            $table->string('sto_id', 18);
            $table->string('description', 100)->nullable();
            $table->date('schedule_start_date')->nullable();
            $table->date('schedule_end_date')->nullable();
            $table->string('area', 20);
            $table->string('results', 100)->nullable();
            $table->string('urut', 3)->nullable();
            $table->string('status', 7)->nullable();
            $table->string('kode_cabang', 2)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary('sto_id'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_stocktake_schedule');
    }
}
