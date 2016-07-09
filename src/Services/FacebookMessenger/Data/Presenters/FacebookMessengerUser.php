<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Presenters;

use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBase as ChatBasePresenter;

class FacebookMessengerUser extends ChatBasePresenter
{
    public function fullName()
    {
        return $this->entity->name ?: $this->entity->first_name . ' ' . $this->entity->last_name;
    }
}
