<?php

namespace PragmaRX\Sdk\Services\Clients\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;

class DeleteClientCommand extends Job
{
	public $id;

	public $user;

	public function handle(ClientRepository $clientRepository)
	{
		return $clientRepository->delete(
            $this->user,
            $this->id
        );
	}
}
