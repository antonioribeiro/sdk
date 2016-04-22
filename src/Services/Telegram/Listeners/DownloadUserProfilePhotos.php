<?php

namespace PragmaRX\Sdk\Services\Telegram\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Telegram\Data\Repositories\Telegram;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramUserWasCreated;

class DownloadUserProfilePhotos implements ShouldQueue
{
    /**
     * @var EventPublisher
     */
    private $eventPublisher;
    /**
     * @var Telegram
     */
    private $telegramRepository;

    public function __construct(EventPublisher $eventPublisher, Telegram $telegramRepository)
	{
        $this->eventPublisher = $eventPublisher;
        $this->telegramRepository = $telegramRepository;
    }

    /**
     * Handle the event.
     *
     * @param TelegramUserWasCreated $event
     */
	public function handle(TelegramUserWasCreated $event)
	{
        $this->telegramRepository->downloadUserAvatar($event->user, $event->bot);

        $this->eventPublisher->publish('ChatListWasUpdated');
	}
}
