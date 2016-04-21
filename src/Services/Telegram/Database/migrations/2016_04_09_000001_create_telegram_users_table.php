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
			$table->string('id', 64)->unique()->primary()->index();

			$table->bigInteger('telegram_id', false)->unsigned()->unique()->index();
			$table->string('first_name');
            $table->json('photos')->nullable();
            $table->string('avatar_id', 64)->nullable();
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
