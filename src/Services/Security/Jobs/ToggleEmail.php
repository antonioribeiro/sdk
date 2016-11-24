<?php

namespace PragmaRX\Sdk\Services\Security\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ToggleEmail extends Job
{
	public $user;

	public $code;

	function __construct($user, $code)
	{
		$this->user = $user;

		$this->code = $code;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->toggleTwoFactorEmail(
            $this->user,
            $this->code
        );
	}
}
