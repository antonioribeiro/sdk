<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_users', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->bigInteger('telegram_id', false)->unsigned()->unique()->index();
			$table->string('first_name');
            $table->uuid('photos')->nullable();
            $table->uuid('avatar_id')->nullable();
            $table->string('last_name')->nullable();
			$table->string('username')->nullable();

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
		Schema::drop('telegram_users');
    }
}
