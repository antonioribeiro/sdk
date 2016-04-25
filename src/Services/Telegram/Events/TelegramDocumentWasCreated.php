<?php

namespace PragmaRX\Sdk\Services\Telegram\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class TelegramDocumentWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var
     */
    public $document;

    /**
     * @var
     */
    public $bot;

    public function __construct($document, $bot)
    {
	    $this->document = $document;

        $this->bot = $bot;
    }
}
