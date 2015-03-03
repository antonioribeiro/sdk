<?php

namespace PragmaRX\Sdk\Services\Passwords\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UpdatePasswordCommand extends SelfHandlingCommand {

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
		$user = $userRepository->updatePassword(
			$this->email,
			$this->password,
			$this->token
		);

		$this->dispatchEventsFor($user);
	}

}
