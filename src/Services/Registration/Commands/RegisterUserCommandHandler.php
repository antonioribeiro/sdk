<?php

namespace PragmaRX\Sdk\Services\Registration\Commands;

use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class RegisterUserCommandHandler extends CommandHandler {

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
		$user = $this->repository->register(
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
