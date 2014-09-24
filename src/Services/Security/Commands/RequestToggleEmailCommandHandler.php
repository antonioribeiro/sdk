<?php namespace PragmaRX\Sdk\Services\Security\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class RequestToggleEmailCommandHandler extends CommandHandler {

	private $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the command.
	 *
	 * @param object $command
	 * @return mixed
	 */
    public function handle($command)
    {
	    $user = $this->userRepository->requestToggleTwoFactorEmail($command->user);

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
