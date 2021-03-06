<?php

namespace PragmaRX\Sdk\Services\Security\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ToggleGoogleCode extends Job
{
	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->toggleTwoFactorGoogle($this->user);
	}
}
