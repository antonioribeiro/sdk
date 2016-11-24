<?php

namespace PragmaRX\Sdk\Services\Passwords\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UpdatePassword extends Job
{
	public $email;

	public $password;

	public $token;

	function __construct($email, $password, $token)
	{
		$this->email = $email;

		$this->password = $password;

		$this->token = $token;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->updatePassword(
			$this->email,
			$this->password,
			$this->token
		);
	}
}
