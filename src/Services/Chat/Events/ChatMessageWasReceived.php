<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatMessageWasReceived extends Event
{
    use SerializesModels;

	public $data;

    public function __construct($data)
    {
	    $this->data = $data;
    }
}
