<?php

namespace PragmaRX\Sdk\Services\Users\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserGotOnline extends Event
{
    use SerializesModels;

	public $user;

    public function __construct($user)
    {
	    $this->user = $user;
    }
}
