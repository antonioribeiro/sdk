<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasTerminated;

class NotifyChatTerminated
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
     * @param ChatWasTerminated $event
     */
	public function handle(ChatWasTerminated $event)
	{
        $this->eventPublisher->publish('ChatTerminated', $event->chat);

        $this->eventPublisher->publish($event->chat->id . ':ChatTerminated', $event->chat);
	}
}
