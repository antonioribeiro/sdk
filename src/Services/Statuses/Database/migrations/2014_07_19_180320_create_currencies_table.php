<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('code', 5);
			$table->string('symbol');
			$table->integer('decimals')->unsigned();
			$table->string('decimal_point');
			$table->string('thousands_separator');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('currencies');
	}

}
