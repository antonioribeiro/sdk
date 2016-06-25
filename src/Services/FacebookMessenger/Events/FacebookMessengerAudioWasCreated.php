<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class FacebookMessengerAudioWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $audio;

    /**
     * @var
     */
    public $bot;

    public function __construct($audio, $bot)
    {
	    $this->audio = $audio;

        $this->bot = $bot;
    }
}
