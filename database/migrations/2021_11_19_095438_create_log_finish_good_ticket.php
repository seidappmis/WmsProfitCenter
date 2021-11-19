<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogFinishGoodTicket extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_finish_good_ticket', function (Blueprint $table) {
			$table->id(); //PK

			$table->string('ticket_no', 100);
			$table->string('model', 100);
			$table->integer('qty');
			$table->string('ean', 100);

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('log_finish_good_ticket');
	}
}
