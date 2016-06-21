<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Events\ChatUserCheckedOut;

class NotifyChatUserCheckedOut
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
     * @param ChatUserCheckedOut $event
     */
	public function handle(ChatUserCheckedOut $event)
	{
        $this->eventPublisher->publish('ChatUserCheckedOut', $event->user->id);
	}
}
