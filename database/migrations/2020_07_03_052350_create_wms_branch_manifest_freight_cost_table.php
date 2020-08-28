<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsBranchManifestFreightCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_branch_manifest_freight_cost', function (Blueprint $table) {
            $table->string('delivery_no', 20); // PK
            $table->string('model', 50); // PK
            $table->string('group_id', 50)->nullable();
            $table->string('do_manifest_no', 50); // PK
            $table->datetime('do_manifest_date')->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->string('vehicle_description', 150)->nullable();
            $table->string('destination_number_driver', 6)->nullable();
            $table->string('destination_name_driver', 100)->nullable();
            $table->string('sold_to', 100)->nullable();
            $table->string('sold_to_code', 10)->nullable();
            $table->string('sold_to_street', 200)->nullable();
            $table->string('ship_to', 100)->nullable();
            $table->string('ship_to_code', 10)->nullable();
            $table->string('city_name', 100)->nullable();
            $table->string('do_date', 12)->nullable();
            $table->string('container_no', 20)->nullable();
            $table->string('seal_no', 20)->nullable();
            $table->string('checker', 50)->nullable();
            $table->string('pdo_no', 50)->nullable();
            $table->string('kode_cabang_pembuat', 2)->nullable();
            $table->string('kode_cabang_penerima', 2)->nullable();
            $table->decimal('cbm_unit', 18, 3);
            $table->integer('quantity');
            $table->decimal('cbm_total', 18, 3)->nullable();
            $table->integer('cost_per_cbm');
            $table->integer('cost_per_coli');
            $table->integer('cost_per_trip');
            $table->decimal('cost_total', 31, 3)->nullable(); //computed

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->primary(['delivery_no', 'model', 'do_manifest_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wms_branch_manifest_freight_cost');
    }
}
