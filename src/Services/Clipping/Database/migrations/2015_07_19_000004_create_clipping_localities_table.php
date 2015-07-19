<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClippingLocalitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clipping_localities', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name');

			$table->string('latitude')->nullable();

			$table->string('longitude')->nullable();

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
		Schema::drop('clipping_localities');
	}
}
