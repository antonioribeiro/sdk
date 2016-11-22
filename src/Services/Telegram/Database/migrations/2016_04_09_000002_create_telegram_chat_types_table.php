<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChatType;

class CreateTelegramChatTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_chat_types', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('name');

			$table->timestamps();
		});

        $this->seed();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('telegram_chat_types');
	}

    private function seed()
    {
        TelegramChatType::create(['name' => 'private']);
        TelegramChatType::create(['name' => 'group']);
        TelegramChatType::create(['name' => 'supergroup']);
        TelegramChatType::create(['name' => 'channel']);
    }
}
