<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cards', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->boolean('is_default');
			$table->string('number', 18);
			$table->string('firstName', 100);
			$table->string('lastName', 100);
			$table->integer('expiryMonth');
			$table->integer('expiryYear');
			$table->integer('cvv');
			$table->string('status');
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
		Schema::drop('cards');
	}

}
