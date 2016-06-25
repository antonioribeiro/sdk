<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories\FacebookMessenger;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerUserWasCreated;

class DownloadUserProfilePhotos // implements ShouldQueue
{
    /**
     * @var EventPublisher
     */
    private $eventPublisher;
    /**
     * @var FacebookMessenger
     */
    private $facebookMessengerRepository;

    public function __construct(EventPublisher $eventPublisher, FacebookMessenger $facebookMessengerRepository)
	{
        $this->eventPublisher = $eventPublisher;
        $this->facebookMessengerRepository = $facebookMessengerRepository;
    }

    /**
     * Handle the event.
     *
     * @param FacebookMessengerUserWasCreated $event
     */
	public function handle(FacebookMessengerUserWasCreated $event)
	{
        $this->facebookMessengerRepository->downloadUserAvatar($event->user, $event->bot);

        $this->eventPublisher->publish('ChatListWasUpdated');
	}
}
