<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class FacebookMessengerVoiceWasCreated extends Event
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
