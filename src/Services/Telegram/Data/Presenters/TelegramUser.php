<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBase as ChatBasePresenter;

class TelegramUser extends ChatBasePresenter
{
    public function fullName()
    {
        return $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}
