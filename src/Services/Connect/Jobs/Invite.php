<?php

namespace PragmaRX\Sdk\Services\Connect\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class InviteCommand extends Job
{
	public $user;

	public $emails;

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->inviteUsers(
			$this->user,
			$this->emails
		);
	}
}
