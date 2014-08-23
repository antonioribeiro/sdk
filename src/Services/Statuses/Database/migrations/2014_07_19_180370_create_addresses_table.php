<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');

			// A realty must always have at least the country, state and city
			$table->integer('city_id')->unsigned();

			$table->string('street')->nullable();
			$table->string('number')->nullable();
			$table->string('neighborhood')->nullable();
			$table->string('zipcode', 9)->nullable();
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();

			$table->timestamps();
		});

		Schema::table('addresses', function(Blueprint $table)
		{
			$table->foreign('city_id')
					->references('id')
					->on('cities')
					->onUpdate('cascade')
					->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('addresses');
	}

}
