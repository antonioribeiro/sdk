<?php

namespace PragmaRX\Sdk\Services\Accounts\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SignInCommand extends SelfHandlingCommand {

	public $email;

	public $password;

	public $remember;

	function __construct($email, $password, $remember)
	{
		$this->email = $email;

		$this->password = $password;

		$this->remember = $remember;
	}

	public function handle(UserRepository $userRepository)
	{
		$credentials = [
			'email' => $this->email,
			'password' => $this->password,
			'remember' => $this->remember
		];

		$result = $userRepository->authenticate($credentials);

		$this->dispatchEventsFor($result['user']);

		return $result;
	}

}
