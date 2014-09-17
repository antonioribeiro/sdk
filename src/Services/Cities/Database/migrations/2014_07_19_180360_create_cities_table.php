<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('cities', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();
			$table->string('name');
			$table->string('abbreviation');
			$table->string('state_id', 64);
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->timestamps();
		});

		Schema::table('cities', function(Blueprint $table)
		{
			$table->foreign('state_id')
					->references('id')
					->on('states')
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
		Schema::drop('cities');
	}

}
