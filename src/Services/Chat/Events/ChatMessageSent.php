<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent extends Event
{
    use SerializesModels;

	public $chatId;

	public $username;

	public $message;

    public function __construct($chatId, $username, $message)
    {
	    $this->chatId = $chatId;

	    $this->username = $username;

	    $this->message = $message;
    }
}
