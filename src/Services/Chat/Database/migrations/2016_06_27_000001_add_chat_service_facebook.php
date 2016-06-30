<?php

use PragmaRX\Support\Migration;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;

class AddChatServiceFacebook extends Migration
{
    private $name = 'Facebook';

    public function migrateUp()
	{
        ChatService::create([
            'name' => $this->name
        ]);
	}

	public function migrateDown()
	{
        if ($service = ChatService::where('name', $this->name)->first())
        {
            $service->delete();
        }
	}
}
