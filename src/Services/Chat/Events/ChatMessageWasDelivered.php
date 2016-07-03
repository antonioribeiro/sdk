<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatMessageWasDelivered extends Event
{
    use SerializesModels;

	public $message;

    public function __construct($message)
    {
	    $this->message = $message;
    }
}
