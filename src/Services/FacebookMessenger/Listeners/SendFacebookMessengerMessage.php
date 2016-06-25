<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Listeners;

use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories\FacebookMessenger;
use PragmaRX\Sdk\Services\FacebookMessenger\Events\FacebookMessengerAudioWasCreated;

class SendFacebookMessengerMessage
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
     * @param FacebookMessengerAudioWasCreated $event
     */
    public function handle(ChatMessageWasSent $event)
    {
        if ($event->data['message_model']->chat->facebook_messenger_chat_id)
        {
            $this->facebookMessengerRepository->sendMessage($event->data['message_model']);
        }

        $this->eventPublisher->publish('ChatListWasUpdated');
    }
}
