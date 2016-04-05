<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;

class BroadcastLoggedUser
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
	 * @param UserWasAuthenticated $event
	 */
	public function handle(UserWasAuthenticated $event)
	{
        $this->eventPublisher->publish('UserAuthenticated');
	}
}
