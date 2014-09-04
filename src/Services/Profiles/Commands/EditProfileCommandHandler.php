<?php

namespace PragmaRX\Sdk\Services\Profiles\Commands;

use Auth;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class EditProfileCommandHandler extends CommandHandler {

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
		$user = $this->repository->update(
			Auth::user(),
			$command->first_name,
			$command->last_name,
			$command->username,
			$command->email,
			$command->bio,
			$command->avatar_id,
			$command->contact_information
		);

		$this->dispatchEventsFor($user);

		return $user;
	}
}
