<?php

namespace PragmaRX\Sdk\Services\Users\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Users\Events\UserWentOffline;

class BroadcastUserIsOffline
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
     * @param UserWentOffline $event
     */
    public function handle(UserWentOffline $event)
    {
        $this->eventPublisher->publish('UserLoggedOut');
    }
}
