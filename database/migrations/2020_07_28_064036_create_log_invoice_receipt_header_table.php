<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInvoiceReceiptHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_invoice_receipt_header', function (Blueprint $table) {
            $table->string('id', 20);
            $table->string('invoice_receipt_no', 100)->nullable();
            $table->string('invoice_receipt_id', 100)->nullable();
            $table->date('invoice_receipt_date')->nullable();
            $table->string('kwitansi_no', 100)->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->decimal('ppn', 18, 2);
            $table->decimal('pph', 18, 2);
            $table->bigInteger('amount_ppn');
            $table->bigInteger('amount_pph');

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->dateTime('create_receipt_date')->nullable();
            $table->string('create_receipt_by', 50)->nullable();
            $table->integer('receipt_no_num')->nullable();
            $table->integer('receipt_id_num')->nullable();
            $table->string('remarks', 100)->nullable();
            $table->date('invoice_receipt_no_date')->nullable();
            $table->bigInteger('amount_before_tax')->nullable();
            $table->bigInteger('amount_after_tax')->nullable();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_invoice_receipt_header');
    }
}
