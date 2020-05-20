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
            $table->id();
            $table->string('code');
            $table->text('expedition_name');
            $table->text('address')->nullable();
            $table->string('sap_code');
            $table->integer('npwp')->nullable();
            $table->string('contact_person');
            $table->text('phone1')->nullable();
            $table->text('phone2')->nullable();
            $table->string('fax')->nullable();
            $table->string('bank')->nullable();
            $table->string('currency')->nullable();
            $table->boolean('active')->nullable()->default(false);

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('master_expedition');
    }
}
