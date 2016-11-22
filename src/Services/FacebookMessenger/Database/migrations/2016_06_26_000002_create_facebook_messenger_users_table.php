<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_users', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->bigInteger('facebook_messenger_id', false)->unsigned()->unique()->index();
            $table->string('name')->nullable();
			$table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('locale')->nullable();
            $table->string('timezone')->nullable();
            $table->string('gender')->nullable();

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
		Schema::drop('facebook_messenger_users');
    }
}
