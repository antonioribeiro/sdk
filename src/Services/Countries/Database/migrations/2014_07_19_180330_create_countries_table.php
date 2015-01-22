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
			$table->string('id', 64)->primary();
			$table->string('code', 5);
			$table->string('name');
			$table->string('currency_id', 64);
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->timestamps();
		});

		Country::create(['name' => 'Brazil', 'code' => 'BR', 'currency_id' => $currencies[0]->id]);
		Country::create(['name' => 'Swiss', 'code' => 'CH', 'currency_id' => $currencies[1]->id]);
		Country::create(['name' => 'United States', 'code' => 'US', 'currency_id' => $currencies[2]->id]);
		Country::create(['name' => 'Italy', 'code' => 'IT', 'currency_id' => $currencies[3]->id]);
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
