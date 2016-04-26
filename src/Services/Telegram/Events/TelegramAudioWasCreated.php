<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramAudioWasCreated extends Event
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
