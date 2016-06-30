<?php

namespace PragmaRX\Sdk\Services\Chat\Listeners;

use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerMessageReceived;

class TransferFacebookMessengerMessageToChat
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
     * @param FacebookMessengerMessageReceived $event
     */
	public function handle(FacebookMessengerMessageReceived $event)
	{
        $this->chatRepository->receiveMessage($event->message);
	}
}
