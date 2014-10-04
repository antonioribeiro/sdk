<?php

namespace PragmaRX\Sdk\Services\Passwords\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class UpdatePasswordCommandHandler extends CommandHandler {

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
		$user = $this->userRepository->updatePassword(
			$command->email,
			$command->password,
			$command->token
		);

		$this->dispatchEventsFor($user);
	}

}
