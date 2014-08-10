<?php namespace PragmaRX\SDK\Accounts;

use PragmaRX\SDK\Users\UserRepository;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class ActivateCommandHandler implements CommandHandler {

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
