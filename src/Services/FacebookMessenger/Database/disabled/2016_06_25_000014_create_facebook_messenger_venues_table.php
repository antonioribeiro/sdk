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
			$table->uuid('id')->unique()->primary()->index();

            $table->uuid('location_id')->index();
            $table->uuid('title');
            $table->uuid('address');
            $table->uuid('foursquare_id')->nullable();

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
