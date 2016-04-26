<?php

namespace PragmaRX\Sdk\Services\Telegram\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Telegram\Data\Repositories\Telegram;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramVoiceWasCreated;

class DownloadTelegramVoice // implements ShouldQueue
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
     * @param TelegramVoiceWasCreated $event
     */
	public function handle(TelegramVoiceWasCreated $event)
	{
        $this->telegramRepository->downloadVoice($event->voice, $event->bot);

        $this->eventPublisher->publish('ChatListWasUpdated');
	}
}
