<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatWasResponded extends Event
{
    use SerializesModels;

	public $response;

    public function __construct($response)
    {
	    $this->response = $response;
    }
}
