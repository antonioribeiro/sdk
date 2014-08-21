<?php

namespace PragmaRX\SDK\Services\Registration\Commands;

use PragmaRX\SDK\Services\Users\Data\Entities\User;
use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;
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
