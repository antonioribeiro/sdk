<?php

namespace PragmaRX\Sdk\Services\Follow\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class UnfollowUserCommandHandler extends CommandHandler {

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
		return $this->userRepository->unfollow($command->user_to_unfollow, $command->user_id);
	}

}
