<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerVenuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_venues', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->string('location_id', 64)->index();
            $table->string('title', 64);
            $table->string('address', 64);
            $table->string('foursquare_id', 64)->nullable();

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
		Schema::drop('facebook_messenger_venues');
	}
}
