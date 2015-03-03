<?php

namespace PragmaRX\Sdk\Services\Security\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ToggleEmailCommand extends SelfHandlingCommand {

	public $user;

	public $code;

	function __construct($user, $code)
	{
		$this->user = $user;

		$this->code = $code;
	}
	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->toggleTwoFactorEmail(
			$this->user,
			$this->code
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
