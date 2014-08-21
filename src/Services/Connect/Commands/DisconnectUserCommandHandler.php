<?php

namespace PragmaRX\SDK\Services\Connect\Commands;

use Laracasts\Commander\CommandHandler;
use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;

class DisconnectUserCommandHandler implements CommandHandler {

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
