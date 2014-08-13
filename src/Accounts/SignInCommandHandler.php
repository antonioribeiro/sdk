<?php namespace PragmaRX\SDK\Accounts;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use PragmaRX\SDK\Users\UserRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Auth;

class SignInCommandHandler implements CommandHandler {

	use DispatchableTrait;

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
	 * @throws Exceptions\InvalidPassword
	 */
    public function handle($command)
    {
	    $credentials = [
		    'email' => $command->email,
		    'password' => $command->password
	    ];

	    try
	    {
		    if( ! $user = Auth::authenticate($credentials))
		    {
			    throw new Exceptions\InvalidPassword();
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
