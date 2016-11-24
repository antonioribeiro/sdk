<?php

namespace PragmaRX\Sdk\Services\Clients\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;

class UpdateClientCommand extends Job
{
	public $id;

	public $user;

	public $first_name;

	public $last_name;

	public $email;

	public $notes;

	public $color;

	public $birthdate;

	public function handle(ClientRepository $clientRepository)
	{
		return $clientRepository->update(
            $this->user,
            $this->id,
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->notes,
            $this->color,
            $this->birthdate
        );
	}
}
