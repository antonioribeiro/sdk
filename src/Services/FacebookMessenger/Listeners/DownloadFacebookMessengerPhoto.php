<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories\FacebookMessenger;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerPhotoWasCreated;

class DownloadFacebookMessengerPhoto // implements ShouldQueue
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
     * @param FacebookMessengerPhotoWasCreated $event
     */
	public function handle(FacebookMessengerPhotoWasCreated $event)
	{
        $this->facebookMessengerRepository->downloadPhoto($event->photo, $event->bot);

        $this->eventPublisher->publish('ChatListWasUpdated');
	}
}
