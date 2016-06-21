<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Events\ChatUserCheckedIn;

class NotifyChatUserCheckedIn
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
     * @param ChatUserCheckedIn $event
     */
	public function handle(ChatUserCheckedIn $event)
	{
        $this->eventPublisher->publish('ChatUserCheckedIn', $event->user->id);
	}
}
