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
            $table->string('location', 50)->nullable();
            $table->string('claim', 15)->nullable();
            $table->integer('submit_by')->nullable();
            $table->datetime('submit_date')->nullable();

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
