<?php

namespace PragmaRX\Sdk\Services\Follow\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class FollowUserCommandHandler extends CommandHandler {

	protected $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		return $this->userRepository->follow($command->user_to_follow, $command->user_id);
	}

}
