<?php

namespace PragmaRX\Sdk\Services\Clients\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;

class AddClientCommand extends Job
{
	public $user;

	public $first_name;

	public $last_name;

	public $email;

	public $birthdate;

	public function handle(ClientRepository $clientRepository)
	{
		return $clientRepository->create(
			$this->user,
			$this->first_name,
			$this->last_name,
			$this->email,
			$this->birthdate
		);
	}
}
