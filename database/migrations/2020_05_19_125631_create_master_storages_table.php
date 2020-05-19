<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_storages', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang_id', 2)->nullable();
            $table->string('sto_loc_code_short', 2)->nullable();
            $table->string('sto_loc_code_long', 4)->nullable();
            $table->integer('sto_type_id')->nullable();
            $table->string('sto_type_desc', 100)->nullable();
            $table->integer('total_max_pallet')->nullable();
            $table->boolean('intransit')->nullable();
            $table->decimal('used_space', 8, 2)->nullable();
            $table->decimal('space_wh', 8, 2)->nullable();
            $table->decimal('hand_pallet_space', 8, 2)->nullable();

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
        Schema::dropIfExists('master_storages');
    }
}
