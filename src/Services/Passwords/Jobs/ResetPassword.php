<?php

namespace PragmaRX\Sdk\Services\Passwords\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ResetPassword extends Job
{
	public $email;

	public $username;

	function __construct($email, $username)
	{
		$this->email = $email;

		$this->username = $username;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->resetPassword($this->email, $this->username);
	}
}
