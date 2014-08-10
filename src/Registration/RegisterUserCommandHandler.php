<?php

namespace PragmaRX\SDK\Registration;

use PragmaRX\SDK\Users\User;
use PragmaRX\SDK\Users\UserRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class RegisterUserCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $repository;

	function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		$user = User::register(
			$command->first_name,
			$command->username,
			$command->email,
			$command->password
		);

		$this->repository->save($user);

		$this->dispatchEventsFor($user);

		return $user;
	}
}
