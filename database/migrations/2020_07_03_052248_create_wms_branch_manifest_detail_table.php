<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsBranchManifestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_branch_manifest_detail', function (Blueprint $table) {
            $table->id();
            $table->string('do_manifest_no', 50); // FK
            $table->integer('no_urut')->nullable();
            $table->string('delivery_no', 20)->nullable();
            $table->string('invoice_no', 10)->nullable();
            $table->tinyInteger('ambil_sendiri')->nullable();
            $table->string('model', 50)->nullable();
            $table->string('expedition_code', 3)->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->string('sold_to', 100)->nullable();
            $table->string('sold_to_code', 10)->nullable();
            $table->string('sold_to_street', 200)->nullable();
            $table->string('ship_to', 100)->nullable();
            $table->string('ship_to_code', 10)->nullable();
            $table->string('city_code', 10)->nullable();
            $table->string('city_name', 100)->nullable();
            $table->string('do_date', 12)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('cbm', 18, 3)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->string('branch_id', 20)->nullable();
            $table->string('do_internal', 50)->nullable();
            $table->string('reservasi_no', 50)->nullable();
            $table->decimal('nilai_ritase', 18, 3);
            $table->decimal('nilai_ritase2', 18, 3);
            $table->decimal('nilai_cbm', 18, 3);
            $table->string('code_sales', 2)->nullable();
            $table->tinyInteger('tcs');
            $table->tinyInteger('do_return');
            $table->tinyInteger('status_confirm');
            $table->datetime('confirm_date')->nullable();
            $table->string('confirm_by', 50)->nullable();
            $table->integer('lead_time');
            $table->string('kode_cabang', 2)->nullable();
            $table->string('region', 100)->nullable();
            $table->datetime('actual_time_arrival')->nullable();
            $table->datetime('actual_unloading_date')->nullable();
            $table->datetime('doc_do_return_date')->nullable();
            $table->integer('delivery_items')->nullable();
            $table->tinyInteger('do_reject');

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
        Schema::dropIfExists('wms_branch_manifest_detail');
    }
}
