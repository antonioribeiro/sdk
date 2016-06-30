<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerLocationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_locations', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->float('longitude', false)->index();
            $table->float('latitude')->index();

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
		Schema::drop('facebook_messenger_locations');
	}
}
