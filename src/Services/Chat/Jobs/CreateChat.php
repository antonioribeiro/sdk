<?php

namespace PragmaRX\Sdk\Services\Chat\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class CreateChat extends Job
{
    public $name;

    public $email;

    public $clientId;

    public $layout;

    public function handle(ChatRepository $repository) {
        return $repository->create(
            $this->name,
            $this->email,
            $this->clientId,
            null,
            $this->layout
        );
    }
}
