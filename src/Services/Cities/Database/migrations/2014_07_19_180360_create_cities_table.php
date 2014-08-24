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
			$table->increments('id');
			$table->string('name');
			$table->string('abbreviation');
			$table->integer('state_id')->unsigned();
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
