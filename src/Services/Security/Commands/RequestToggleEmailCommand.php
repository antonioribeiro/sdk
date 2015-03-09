<?php

namespace PragmaRX\Sdk\Services\Security\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class RequestToggleEmailCommand extends SelfHandlingCommand {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->requestToggleTwoFactorEmail($this->user);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
