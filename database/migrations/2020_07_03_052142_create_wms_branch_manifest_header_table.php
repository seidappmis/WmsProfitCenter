<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsBranchManifestHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_branch_manifest_header', function (Blueprint $table) {
            $table->string('driver_register_id', 50);
            $table->string('do_manifest_no', 50);
            $table->string('expedition_code', 3)->nullable();
            $table->string('expedition_name', 100)->nullable();
            $table->string('driver_id', 10)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('vehicle_number', 11)->nullable();
            $table->string('vehicle_code_type', 6)->nullable();
            $table->string('vehicle_description', 150)->nullable();
            $table->date('do_manifest_date')->nullable();
            $table->datetime('do_manifest_time')->nullable();
            $table->string('destination_number_driver', 6)->nullable();
            $table->string('destination_name_driver', 100)->nullable();
            $table->string('city_code', 10)->nullable();
            $table->string('city_name', 100)->nullable();
            $table->string('container_no', 20)->nullable();
            $table->string('seal_no', 20)->nullable();
            $table->string('checker', 50)->nullable();
            $table->string('pdo_no', 50)->nullable();

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->string('vehicle_description', 150)->nullable();
            $table->string('kode_cabang', 20)->nullable();
            $table->tinyInteger('status_complete');
            $table->integer('urut_manifest');
            $table->tinyInteger('tcs');
            $table->tinyInteger('ambil_sendiri');
            $table->integer('id_freight_cost')->nullable();
            $table->decimal('ritase', 18, 3);
            $table->decimal('cbm', 18, 3);
            $table->tinyInteger('manifest_return');
            $table->string('manifest_type', 20);
            $table->tinyInteger('status_inv_recieve');
            $table->tinyInteger('have_lcl');
            $table->string('lcl_from_driver_register_id', 50)->nullable();
            $table->string('lcl_from_manifest_no', 50)->nullable();
            $table->datetime('lcl_created_date')->nullable();
            $table->string('lcl_created_by', 50)->nullable();
            $table->tinyInteger('have_resend');
            $table->tinyInteger('manifest_resend');
            $table->string('r_from_manifest', 50)->nullable();
            $table->string('r_driver_register_id', 50)->nullable();
            $table->datetime('r_created_date')->nullable();
            $table->string('r_created_by', 50)->nullable();

            $table->primary('do_manifest_no'); // add primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wms_branch_manifest_header');
    }
}
