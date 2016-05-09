<?php

namespace PragmaRX\Sdk\Services\Users\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Users\Events\UserGotOnline;

class BroadcastUserIsOnline
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
     * @param UserGotOnline $event
     */
    public function handle(UserGotOnline $event)
    {
        $this->eventPublisher->publish('UserLoggedIn');
    }
}
