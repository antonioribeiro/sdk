<?php

namespace PragmaRX\Sdk\Services\Passwords\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ResetPasswordCommand extends SelfHandlingCommand {

	public $email;

	public $username;

	function __construct($email, $username)
	{
		$this->email = $email;

		$this->username = $username;
	}

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->resetPassword($this->email, $this->username);

		$this->dispatchEventsFor($user);
	}

}
