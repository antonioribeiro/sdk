<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramVideoWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $video;

    /**
     * @var
     */
    public $bot;

    public function __construct($video, $bot)
    {
	    $this->video = $video;

        $this->bot = $bot;
    }
}
