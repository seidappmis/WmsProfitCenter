<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrConceptTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tr_concept', function (Blueprint $table) {
      $table->string('invoice_no', 10);
      $table->integer('line_no');
      $table->string('output_date', 8)->nullable();
      $table->string('output_time', 6)->nullable();
      $table->string('destination_number', 6)->nullable();
      $table->string('vehicle_code_type', 6)->nullable();
      $table->string('car_no', 50)->nullable();
      $table->string('cont_no', 50)->nullable();
      $table->string('checkin_date', 8)->nullable();
      $table->string('checkin_time', 6)->nullable();
      $table->integer('expedition_id')->nullable();
      $table->string('delivery_no', 20);
      $table->integer('delivery_items');
      $table->string('model', 50);
      $table->integer('quantity');
      $table->decimal('cbm', 18, 3);
      $table->string('ship_to', 100)->nullable();
      $table->string('sold_to', 100)->nullable();
      $table->string('ship_to_city', 100)->nullable();
      $table->string('ship_to_district', 100)->nullable();
      $table->string('ship_to_street', 200)->nullable();
      $table->string('sold_to_city', 100)->nullable();
      $table->string('sold_to_district', 100)->nullable();
      $table->string('sold_to_street', 200)->nullable();
      $table->string('remarks', 200)->nullable();
      // $table->string('created_date', 100)->nullable();
      // $table->string('created_by', 100)->nullable();
      $table->datetime('split_date')->nullable();
      $table->string('split_by', 50)->nullable();
      $table->string('area', 20)->nullable();
      $table->string('concept_type', 50)->nullable();
      $table->string('expedition_name', 100)->nullable();
      $table->string('sold_to_code', 10)->nullable();
      $table->string('ship_to_code', 10)->nullable();
      $table->string('expedition_code', 6)->nullable();
      $table->string('code_sales', 2)->nullable();
      $table->timestamps();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();

      $table->primary(['invoice_no', 'line_no']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tr_concept');
  }
}
