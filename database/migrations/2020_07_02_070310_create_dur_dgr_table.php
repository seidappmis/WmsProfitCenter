<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurDgrTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('dur_dgr', function (Blueprint $table) {
         $table->id();
         $table->string('dgr_no', 30);
         $table->string('location', 50)->nullable();
         $table->string('claim', 15)->nullable();

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
      Schema::dropIfExists('dur_dgr');
   }
}
