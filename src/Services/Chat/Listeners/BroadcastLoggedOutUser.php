<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Login\Events\UserWasLoggedOut;

class BroadcastLoggedOutUser
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
     * @param UserWasLoggedOut $event
     */
	public function handle(UserWasLoggedOut $event)
	{
        $this->eventPublisher->publish('UserLoggedOut');
	}
}
