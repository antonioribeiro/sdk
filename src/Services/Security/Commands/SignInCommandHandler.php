<?php namespace PragmaRX\Sdk\Services\Accounts\Commands;

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
	 * @throws InvalidPassword
	 */
    public function handle($command)
    {
	    $credentials = [
		    'email' => $command->email,
		    'password' => $command->password,
		    'remember' => $command->remember
	    ];

	    $result = $this->userRepository->authenticate($credentials);

	    $this->dispatchEventsFor($result['user']);

	    return $result;
    }

}
