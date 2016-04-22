<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramUserWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $bot;

    public function __construct($user, $bot)
    {
	    $this->user = $user;

        $this->bot = $bot;
    }
}
