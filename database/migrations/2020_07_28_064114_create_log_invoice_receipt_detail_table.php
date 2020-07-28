<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogInvoiceReceiptDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_invoice_receipt_detail', function (Blueprint $table) {
            $table->id();
            $table->string('id_header', 20)->nullable(); // FK
            $table->string('invoice_receipt_no', 100)->nullable();
            $table->string('delivery_no', 20)->nullable();
            $table->string('do_manifest_no', 50)->nullable();
            $table->date('do_manifest_date')->nullable();
            $table->boolean('ritase_type');
            $table->integer('ritase_freight_cost');
            $table->date('do_date')->nullable();
            $table->string('model', 50)->nullable();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('vehicle_description', 100)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('sold_to', 100)->nullable();
            $table->string('sold_to_code', 10)->nullable();
            $table->string('sold_to_street', 200)->nullable();
            $table->string('ship_to', 100)->nullable();
            $table->string('ship_to_code', 10)->nullable();
            $table->string('city_code_header', 10)->nullable();
            $table->string('city_name_header', 100)->nullable();
            $table->string('city_code', 10)->nullable();
            $table->string('city_name', 100)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('cbm_vehicle', 18, 3)->nullable();
            $table->decimal('cbm_do', 18, 3)->nullable();
            $table->bigInteger('freight_cost_cbm');
            $table->decimal('freight_cost', 18, 3);
            $table->integer('cbm_amount');
            $table->decimal('ritase_amount', 18, 3);
            $table->integer('ritase2_amount');
            $table->integer('multidro_amount')->nullable();
            $table->integer('unloading_amount')->nullable();
            $table->integer('overstay_amount')->nullable();
            $table->string('code_sales', 2)->nullable();
            $table->integer('lead_time');
            $table->string('kode_cabang', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('area', 20)->nullable();
            $table->string('acc_code', 50)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('update_by')->nullable();

            $table->string('remarks', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_invoice_receipt_detail');
    }
}
