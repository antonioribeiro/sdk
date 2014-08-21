<?php namespace PragmaRX\SDK\Services\Accounts\Commands;

use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;

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
