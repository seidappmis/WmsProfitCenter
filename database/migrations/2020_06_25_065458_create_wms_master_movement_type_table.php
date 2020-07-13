<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsMasterMovementTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_master_movement_type', function (Blueprint $table) {
            $table->id();
            $table->string('group_id', 50);
            $table->string('transactions', 100)->nullable();
            $table->string('movement_code', 10)->nullable();
            $table->string('action', 50)->nullable();
            $table->string('action_description', 150)->nullable();
            $table->string('from_desc', 100)->nullable();
            $table->string('to_desc', 100)->nullable();
            $table->string('modul_name', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wms_master_movement_type');
    }
}
