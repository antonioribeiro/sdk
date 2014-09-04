<?php

namespace PragmaRX\Sdk\Services\Block\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class UnblockUserCommandHandler extends CommandHandler {

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
		return $this->userRepository->unblock($command->user_to_unblock, $command->user_id);
	}

}
