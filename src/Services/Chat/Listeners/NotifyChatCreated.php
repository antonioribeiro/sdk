<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\ChatWasCreated;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;

class NotifyChatCreated
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
     * @param ChatWasCreated $event
     */
	public function handle(ChatWasCreated $event)
	{
	    $data = ['chat' => $event->chat, 'allChats' => $event->allChats];

        $this->eventPublisher->publish('ChatWasCreated', $data);
	}
}
