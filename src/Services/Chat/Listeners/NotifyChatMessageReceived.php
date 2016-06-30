<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasReceived;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;

class NotifyChatMessageReceived
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
     * @param ChatMessageWasSent $event
     */
	public function handle(ChatMessageWasReceived $event)
	{
        $this->eventPublisher->publish($event->data['chat_id'], $event->data);
	}
}
