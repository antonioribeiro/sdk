<?php

namespace PragmaRX\Sdk\Services\Block\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UnblockUserCommand extends SelfHandlingCommand {

	public $user_to_unblock;

	public $user_id;

	function __construct($user_to_unblock, $user_id)
	{
		$this->user_to_unblock = $user_to_unblock;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->unblock($this->user_to_unblock, $this->user_id);
	}

}
