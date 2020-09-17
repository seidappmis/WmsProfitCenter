<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsStorageTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_storage_type', function (Blueprint $table) {
            $table->id();
            $table->string('storage_type', 100)->nullable();
            $table->integer('storage_rank')->nullable();
            $table->boolean('storage_intransit')->nullable();
            
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
        Schema::dropIfExists('wms_storage_type');
    }
}
