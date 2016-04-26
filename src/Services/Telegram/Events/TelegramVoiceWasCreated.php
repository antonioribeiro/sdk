<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramVoiceWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $voice;

    /**
     * @var
     */
    public $bot;

    public function __construct($voice, $bot)
    {
	    $this->voice = $voice;

        $this->bot = $bot;
    }
}
