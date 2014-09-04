<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class DisconnectUserCommandHandler extends CommandHandler {

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
		return $this->userRepository->disconnect($command->user_to_disconnect, $command->user_id);
	}

}
