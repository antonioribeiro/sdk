<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatWasRead extends Event
{
    use SerializesModels;

	public $read;

    public function __construct($read)
    {
	    $this->read = $read;
    }
}
