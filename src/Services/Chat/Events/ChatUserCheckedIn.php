<?php

namespace PragmaRX\Sdk\Services\Chat\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ChatUserCheckedIn extends Event
{
    use SerializesModels;

	public $user;

    public function __construct($user)
    {
	    $this->user = $user;
    }
}
