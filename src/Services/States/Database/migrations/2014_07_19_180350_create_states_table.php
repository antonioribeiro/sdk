<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('states', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 5);
			$table->string('name')->nullable();
			$table->integer('country_id')->unsigned();
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->timestamps();
		});

		Schema::table('states', function(Blueprint $table)
		{
			$table->foreign('country_id')
					->references('id')
					->on('countries')
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
		Schema::drop('states');
	}

}
