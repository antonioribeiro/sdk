<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessageSent extends Event implements ShouldBroadcast
{
    use SerializesModels;

	public $username;

	public $message;

    public function __construct($username, $message)
    {
	    $this->username = $username;
	    $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['chat-channel'];
    }
}
