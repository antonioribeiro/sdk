<?php

namespace PragmaRX\Sdk\Services\Block\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class BlockUserCommand extends SelfHandlingCommand {

	public $user_to_block;

	public $user_id;

	function __construct($user_to_block, $user_id)
	{
		$this->user_to_block = $user_to_block;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->block($this->user_to_block, $this->user_id);
	}

}
