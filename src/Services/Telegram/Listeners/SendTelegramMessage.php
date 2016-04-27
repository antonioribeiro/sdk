<?php

namespace PragmaRX\Sdk\Services\Telegram\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Telegram\Data\Repositories\Telegram;
use PragmaRX\Sdk\Services\Telegram\Events\TelegramAudioWasCreated;

class SendTelegramMessage
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
     * @param TelegramAudioWasCreated $event
     */
    public function handle(ChatMessageWasSent $event)
    {
        if ($event->data['message_model']->chat->telegram_chat_id)
        {
            $this->telegramRepository->sendMessage($event->data['message_model']);
        }

        $this->eventPublisher->publish('ChatListWasUpdated');
    }
}
