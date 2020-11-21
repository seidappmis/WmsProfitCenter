<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurDgrDetailTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('dur_dgr_detail', function (Blueprint $table) {
         $table->id();

         $table->integer('dur_dgr_id')->length(20)->nullable();
         $table->integer('berita_acara_detail_id')->length(20)->nullable();
         $table->string('description')->nullable();
         $table->integer('qty')->nullable();
         $table->string('remarsk')->nullable();

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
      Schema::dropIfExists('dur_dgr_detail');
   }
}
