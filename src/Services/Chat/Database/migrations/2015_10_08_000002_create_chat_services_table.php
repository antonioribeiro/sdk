<?php

use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatServicesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_services', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('name')->index();

			$table->timestamps();
		});

		$this->seed();
	}

	public function migrateDown()
	{
		Schema::drop('chat_services');
	}

	public function seed()
	{
		ChatService::create([
			'name' => 'Chat'
        ]);

		ChatService::create([
			'name' => 'Telegram'
        ]);

		ChatService::create([
            'name' => 'WhatsApp'
        ]);

		ChatService::create([
            'name' => 'IRC'
        ]);
	}
}
