<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurMarineCargoTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('dur_marine_cargo', function (Blueprint $table) {
         $table->id();
         $table->integer('dur_dgr_id')->length(20)->nullable();
         $table->string('insurance_policy_no', 30);
         $table->string('sailed_on')->nullable();
         $table->string('vessel_name')->nullable();
         $table->datetime('sailed_date')->nullable();
         $table->datetime('arrived_date')->nullable();
         $table->datetime('discharging_date')->nullable();
         $table->datetime('delivery_date')->nullable();
         $table->string('cargo_description')->nullable();
         $table->integer('qty')->nullable();

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
      Schema::dropIfExists('dur_marine_cargo');
   }
}
