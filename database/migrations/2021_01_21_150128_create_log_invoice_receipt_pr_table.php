<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInvoiceReceiptPrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_invoice_receipt_pr', function (Blueprint $table) {
            $table->string('group_id_report', 20);
            $table->string('expedition_name', 100);
            $table->string('payment_requisition', 20)->nullable();

            $table->primary(['group_id_report', 'expedition_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_invoice_receipt_pr');
    }
}
