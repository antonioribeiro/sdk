<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerChatType;

class CreateFacebookMessengerChatTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_chat_types', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

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
		Schema::drop('facebook_messenger_chat_types');
	}

    private function seed()
    {
        FacebookMessengerChatType::create(['name' => 'private']);
        FacebookMessengerChatType::create(['name' => 'group']);
        FacebookMessengerChatType::create(['name' => 'supergroup']);
        FacebookMessengerChatType::create(['name' => 'channel']);
    }
}
