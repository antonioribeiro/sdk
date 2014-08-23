<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('photos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('hash');
			$table->string('path')->nullable();
			$table->string('url')->nullable();
			$table->integer('bytes')->nullable();
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
		Schema::drop('photos');
	}

}
