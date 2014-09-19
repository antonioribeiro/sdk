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
		    $command->remember,
		    $command->authentication_code,
		    $command->two_factor_google_token,
		    $command->two_factor_sms_token,
		    $command->two_factor_email_token
	    );

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
