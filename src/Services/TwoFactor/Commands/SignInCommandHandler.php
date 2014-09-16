<?php namespace PragmaRX\Sdk\Services\TwoFactor\Commands;

use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class SignInCommandHandler extends CommandHandler {

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
	    $user = $this->userRepository->authenticateViaTwoFactor(
		    $command->user_id,
		    $command->two_factor_token,
		    $command->authentication_code
	    );

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
