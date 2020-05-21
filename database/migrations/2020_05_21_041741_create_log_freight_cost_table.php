<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogFreightCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_freight_cost', function (Blueprint $table) {
            $table->id();
            $table->string('area', 20);
            $table->string('city_code', 10)->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->decimal('ritase', 18, 3);
            $table->decimal('ritase2', 18, 3)->nullable();
            $table->decimal('cbm', 18, 3);
            $table->boolean('ambil_sendiri')->nullable();
            $table->integer('leadtime');

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
        Schema::dropIfExists('log_freight_cost');
    }
}
