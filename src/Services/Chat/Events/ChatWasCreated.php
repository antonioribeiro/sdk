<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatWasCreated extends Event
{
    use SerializesModels;

	public $chat;

    public $allChats;

    public function __construct($chat, $allChats)
    {
	    $this->chat = $chat;
        $this->allChats = $allChats;
    }
}
