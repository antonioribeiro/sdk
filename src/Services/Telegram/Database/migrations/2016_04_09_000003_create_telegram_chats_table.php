<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramChatsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_chats', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->bigInteger('telegram_id', false)->unsigned()->unique()->index();
			$table->string('telegram_chat_type_id', 64);
            $table->string('title')->nullable();
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

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
		Schema::drop('telegram_chats');
	}
}
