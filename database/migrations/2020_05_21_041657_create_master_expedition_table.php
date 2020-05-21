<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterExpeditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_expedition', function (Blueprint $table) {
            $table->string('code');
            $table->string('expedition_name',45);
            $table->text('address')->nullable();
            $table->string('sap_code');
            $table->integer('npwp')->nullable();
            $table->string('contact_person')->nullable();
            $table->integer('phone1')->nullable();
            $table->integer('phone2')->nullable();
            $table->integer('fax')->nullable();
            $table->string('bank')->nullable();
            $table->string('currency')->nullable();
            $table->tinyInteger('status_active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->primary('expedition_name');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_expedition');
    }
}
