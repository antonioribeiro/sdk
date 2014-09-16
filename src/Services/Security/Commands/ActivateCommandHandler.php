<?php namespace PragmaRX\Sdk\Services\Accounts\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class ActivateCommandHandler extends CommandHandler {

	private $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the command.
	 *
	 * @param object $command
	 * @throws Exceptions\InvalidActivationToken
	 * @return void
	 */
    public function handle($command)
    {
		$user = $this->userRepository->activate($command->email, $command->token);

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
