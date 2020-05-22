<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrVehicleExpeditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_vehicle_expedition', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('vehicle_detail_description', 100)->nullable();
            $table->string('remark1', 100)->nullable();
            $table->string('remark2', 100)->nullable();
            $table->string('remark3', 100)->nullable();
            $table->string('destination', 50)->nullable();
            $table->boolean('status_active')->nullable();

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
        Schema::dropIfExists('tr_vehicle_expedition');
    }
}
