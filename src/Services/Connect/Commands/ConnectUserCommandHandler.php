<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class ConnectUserCommandHandler extends CommandHandler {

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
		return $this->userRepository->connect($command->user_to_connect, $command->user_id);
	}

}
