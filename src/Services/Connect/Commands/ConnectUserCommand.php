<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ConnectUserCommand extends SelfHandlingCommand {

	public $user_to_connect;

	public $user_id;

	function __construct($user_to_connect, $user_id)
	{
		$this->user_to_connect = $user_to_connect;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->connect($this->user_to_connect, $this->user_id);
	}

}
