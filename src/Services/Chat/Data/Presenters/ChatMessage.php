<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Repositories\Telegram;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Repositories\FacebookMessenger;

class ChatMessage extends Presenter
{
    /**
     * @var Telegram
     */
    private $telegramRepository;

    /**
     * @var FacebookMessenger
     */
    private $facebookMessengerRepository;

    function __construct($entity)
    {
        parent::__construct($entity);

        $this->instantiateRepositories();

        $this->entity = $this->chatFactory($entity);
    }

    private function chatFactory($entity)
    {
        if ($entity->telegram_message_id)
        {
            return $this->telegramRepository->findMessageById($this->entity->telegram_message_id)->present();
        }

        if ($entity->facebook_messenger_message_id)
        {
            return $this->facebookMessengerRepository->findMessageById($this->entity->facebook_messenger_message_id)->present();
        }

        return $entity;
    }

    private function instantiateRepositories()
    {
        $this->telegramRepository = app(Telegram::class);

        $this->facebookMessengerRepository = app(FacebookMessenger::class);
    }

    public function message()
    {
        return $this->entity->message;
    }
}
