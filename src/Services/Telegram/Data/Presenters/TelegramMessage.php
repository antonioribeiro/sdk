<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Presenters;

use PragmaRX\Sdk\Core\Presenter;

class TelegramMessage extends Presenter
{
    public function message()
    {
        return $this->entity->text;
    }
}
