<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramPhotoWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $photo;

    /**
     * @var
     */
    public $bot;

    public function __construct($photo, $bot)
    {
	    $this->photo = $photo;

        $this->bot = $bot;
    }
}
