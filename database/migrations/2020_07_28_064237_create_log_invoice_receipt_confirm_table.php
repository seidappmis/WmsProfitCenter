<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInvoiceReceiptConfirmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_invoice_receipt_confirm', function (Blueprint $table) {
            $table->string('invoice_receipt_id', 100); // PK
            $table->string('expedition_name', 100)->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('confirm_by', 50)->nullable();
            $table->dateTime('confirm_date')->nullable();
            $table->string('group_id_report', 20)->nullable();
            $table->string('create_report_by', 50)->nullable();
            $table->dateTime('create_report_date')->nullable();
            $table->string('logistic_staff', 100)->nullable();
            $table->string('logistic_manager', 100)->nullable();
            $table->string('accounting_division', 100)->nullable();
            $table->string('logistic_ass_manager', 100)->nullable();

            $table->primary('invoice_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_invoice_receipt_confirm');
    }
}
