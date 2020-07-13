<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_driver', function (Blueprint $table) {
            $table->string('expedition_code')->nullable();
            $table->string('driver_id',10);
            $table->string('driver_name')->nullable();
            $table->string('driving_license_type')->nullable();
            $table->string('driving_license_no');
            $table->string('ktp_no')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('remarks1')->nullable();
            $table->string('remarks2')->nullable();
            $table->string('remarks3')->nullable();
            $table->tinyInteger('active_status');
            $table->string('photo_name')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->primary('driver_id');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_driver');
    }
}
