<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_contacts', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

            $table->string('phone_number');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->uuid('telegram_user_id')->nullable();

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
		Schema::drop('telegram_contacts');
	}
}
