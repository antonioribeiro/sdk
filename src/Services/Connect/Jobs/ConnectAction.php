<?php

namespace PragmaRX\Sdk\Services\Connect\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ConnectActionCommand extends Job
{
	public $user;

	public $connection_id;

	public $action;

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->connectAction(
			$this->user,
			$this->connection_id,
			$this->action
		);
	}
}
