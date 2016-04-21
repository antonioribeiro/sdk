<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramUserWasCreated extends Event
{
    use SerializesModels;

	public $user;

    public function __construct($user)
    {
	    $this->user = $user;
    }
}
