<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_cabang', function (Blueprint $table) {
        
            $table->string('code_customer', 8);
            $table->string('code_cabang', 2);
            $table->string('sdes', 3)->nullable();
            $table->string('ldes', 100)->nullable();
            $table->string('tycode', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_date')->nullable();
            $table->integer('updated_date')->nullable();

            $table->primary('code_cabang'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_cabang');
    }
}
