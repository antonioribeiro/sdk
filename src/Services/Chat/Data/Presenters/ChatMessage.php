<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;
use PragmaRX\Sdk\Services\Telegram\Data\Repositories\Telegram;

class ChatMessage extends Presenter
{
    /**
     * @var Telegram
     */
    private $telegramRepository;

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

        return $entity;
    }

    private function instantiateRepositories()
    {
        $this->telegramRepository = app()->make(Telegram::class);
    }

    public function message()
    {
        return $this->entity->message;
    }
}
