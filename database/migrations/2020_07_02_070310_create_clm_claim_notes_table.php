<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClmClaimNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clm_claim_notes', function (Blueprint $table) {
            $table->id();
            $table->string('claim_note_no', 30);
            $table->string('berita_acara_no', 20);
            $table->date('date_of_receipt')->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('driver_name', 50)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('destination', 50)->nullable();
            $table->string('do_no', 15)->nullable();
            $table->string('model_name', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->string('qty')->nullable();
            $table->string('description')->nullable();
            $table->string('location', 50)->nullable();
            $table->string('claim', 15)->nullable();
            $table->string('price', 15)->nullable();
            $table->string('total_price', 15)->nullable();

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
        Schema::dropIfExists('clm_claim_notes');
    }
}
