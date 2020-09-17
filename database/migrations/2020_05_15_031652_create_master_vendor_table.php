<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor', function (Blueprint $table) {
            $table->string('vendor_code', 50);
            $table->string('vendor_name', 100)->nullable();
            $table->string('description', 250)->nullable();
            $table->string('vendor_address', 100)->nullable();
            $table->string('contact_person_name', 50)->nullable();
            $table->string('contact_person_phone', 20)->nullable();
            $table->string('contact_person_email', 50)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary('vendor_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor');
    }
}
