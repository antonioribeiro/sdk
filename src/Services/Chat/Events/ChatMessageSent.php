<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageSent extends Event implements ShouldBroadcast
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

    public function broadcastOn()
    {
        return ['chat-channel'];
    }
}
