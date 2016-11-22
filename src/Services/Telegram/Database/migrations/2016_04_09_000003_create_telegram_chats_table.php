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
			$table->uuid('id')->unique()->primary()->index();

			$table->bigInteger('telegram_id', false)->unsigned()->unique()->index();
            $table->uuid('bot_id')->nullable()->index();
			$table->uuid('telegram_chat_type_id');
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
