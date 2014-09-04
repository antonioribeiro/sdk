<?php namespace PragmaRX\Sdk\Services\Accounts\Commands;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use Auth;

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
		    'password' => $command->password
	    ];

	    try
	    {
		    if ( ! $user = Auth::authenticate($credentials))
		    {
			    throw new InvalidPassword();
		    }
	    }
	    catch (NotActivatedException $exception)
	    {
		    $this->userRepository->checkActivationByEmail($command->email);

		    throw new NotActivatedException();
	    }

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
