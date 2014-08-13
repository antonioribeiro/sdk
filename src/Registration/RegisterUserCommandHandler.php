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
			$command->username,
			$command->email,
			$command->password,
			$command->first_name,
			$command->last_name
		);

		$this->repository->save($user);

		$this->dispatchEventsFor($user);

		return $user;
	}
}
