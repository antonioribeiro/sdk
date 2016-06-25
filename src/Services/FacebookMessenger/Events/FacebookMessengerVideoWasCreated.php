<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class FacebookMessengerVideoWasCreated extends Event
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
