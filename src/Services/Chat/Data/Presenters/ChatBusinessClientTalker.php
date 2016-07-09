<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Presenters;

use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatBase as ChatBasePresenter;

class ChatBusinessClientTalker extends ChatBasePresenter
{
    public function fullName()
    {
        return $this->entity->user->fullName;
    }

    public function avatar()
    {
        $repository = app(ChatRepository::class);

        $role = $repository->findRoleByTalker($this->entity);

        if ($role && $this->entity->client->avatar)
        {
            $avatar = $this->entity->client->avatar->file->getUrl();
        }
        else
        {
            $avatar = $this->entity->user->present()->avatar;
        }

        return $avatar;
    }
}
