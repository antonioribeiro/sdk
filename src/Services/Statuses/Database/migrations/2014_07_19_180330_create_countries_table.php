<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('countries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 5);
			$table->string('name');
			$table->integer('currency_id')->unsigned();
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
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
		Schema::drop('countries');
	}

}
