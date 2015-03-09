<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class DisconnectUserCommand extends SelfHandlingCommand {

	public $user_to_disconnect;

	public $user_id;

	function __construct($user_to_disconnect, $user_id)
	{
		$this->user_to_disconnect = $user_to_disconnect;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->disconnect($this->user_to_disconnect, $this->user_id);
	}

}
