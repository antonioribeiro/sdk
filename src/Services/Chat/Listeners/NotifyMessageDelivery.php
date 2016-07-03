<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasDelivered;

class NotifyMessageDelivery
{
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * @var Chat
     */
    private $chatRepository;

    public function __construct(EventPublisher $eventPublisher, Chat $chatRepository)
	{
        $this->eventPublisher = $eventPublisher;
        $this->chatRepository = $chatRepository;
    }

    /**
     * Handle the event.
     *
     * @param ChatMessageWasDelivered $event
     */
	public function handle(ChatMessageWasDelivered $event)
	{
        $this->chatRepository->markAsDelivered($event->message);
	}
}
