<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasResponded;

class NotifyChatResponded
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
     * @param ChatWasResponded $event
     */
	public function handle(ChatWasResponded $event)
	{
        $this->eventPublisher->publish($event->response['chat']->id . ':ChatResponded');
	}
}
