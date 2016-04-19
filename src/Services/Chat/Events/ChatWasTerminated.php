<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatWasTerminated extends Event
{
    use SerializesModels;

	public $chat;

    public function __construct($chat)
    {
	    $this->chat = $chat;
    }
}
