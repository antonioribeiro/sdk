<?php

namespace PragmaRX\Sdk\Services\Connect\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class AcceptInvitationCommand extends Job
{
	public $user_id;

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->acceptInvitation($this->user_id);
	}
}
