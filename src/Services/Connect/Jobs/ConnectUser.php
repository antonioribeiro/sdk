<?php

namespace PragmaRX\Sdk\Services\Connect\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ConnectUserCommand extends Job
{
	public $user_to_connect;

	public $user_id;

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->connect($this->user_to_connect, $this->user_id);
	}
}
