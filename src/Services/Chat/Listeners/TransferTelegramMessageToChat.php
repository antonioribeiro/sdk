<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Telegram\Events\TelegramMessageReceived;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class TransferTelegramMessageToChat
{
    /**
     * @var ChatRepository
     */
    private $chatRepository;

    public function __construct(ChatRepository $chatRepository)
	{
        $this->chatRepository = $chatRepository;
    }

    /**
     * Handle the event.
     *
     * @param TelegramMessageReceived $event
     */
	public function handle(TelegramMessageReceived $event)
	{
        $this->chatRepository->receiveMessage($event->message);
	}
}
