<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClippingVehiclesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clipping_vehicles', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('name');

			$table->string('url', 1024)->nullable();

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
		Schema::drop('clipping_vehicles');
	}
}
