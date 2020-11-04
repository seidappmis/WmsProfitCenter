<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClmClaimNoteDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clm_claim_note_detail', function (Blueprint $table) {
            $table->id();

            $table->integer('claim_note_id', 20)->nullable();
            $table->integer('berita_acara_detail_id', 20)->nullable();
            $table->date('date_of_receipt')->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('driver_name', 50)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('do_no', 15)->nullable();
            $table->string('model_name', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->string('description')->nullable();
            $table->string('destination')->nullable();
            $table->string('location')->nullable();
            $table->int('qty')->nullable();
            $table->int('price')->nullable();
            $table->int('total_price')->nullable();

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
        Schema::dropIfExists('clm_claim_note_detail');
    }
}
