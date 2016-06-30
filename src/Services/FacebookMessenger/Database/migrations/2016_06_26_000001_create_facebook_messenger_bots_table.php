<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerBotsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_bots', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name')->nullable();
            $table->string('token')->nullable();

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
		Schema::drop('facebook_messenger_bots');
    }
}
