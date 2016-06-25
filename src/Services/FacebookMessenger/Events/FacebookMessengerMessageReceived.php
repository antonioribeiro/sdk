<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class FacebookMessengerMessageReceived extends Event
{
    use SerializesModels;

	public $message;

    public function __construct($message)
    {
	    $this->message = $message;
    }
}
