<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramMessageReceived extends Event
{
    use SerializesModels;

	public $message;

    public function __construct($message)
    {
	    $this->message = $message;
    }
}
