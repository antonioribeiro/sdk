<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\ChatWasRead;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;

class NotifyChatRead
{
    /**
     * @var EventPublisher
     */
    private $eventPublisher;
    
    public function __construct(EventPublisher $eventPublisher)
	{
        $this->eventPublisher = $eventPublisher;
    }

    /**
     * Handle the event.
     *
     * @param ChatWasRead $event
     */
	public function handle(ChatWasRead $event)
	{
        $this->eventPublisher->publish('ChatRead', $event->read);
	}
}
