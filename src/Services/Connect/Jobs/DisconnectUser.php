<?php

namespace PragmaRX\Sdk\Services\Connect\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class DisconnectUserCommand extends Job
{
	public $user_to_disconnect;

	public $user_id;

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->disconnect($this->user_to_disconnect, $this->user_id);
	}
}
