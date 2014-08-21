<?php

namespace PragmaRX\SDK\Services\Profiles\Commands;

use Auth;
use PragmaRX\SDK\Services\Users\Data\Repositories\UserRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class EditProfileCommandHandler implements CommandHandler {

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
		$user = $this->repository->update(
			Auth::user(),
			$command->first_name,
			$command->last_name,
			$command->username,
			$command->email,
			$command->bio
		);

		$this->dispatchEventsFor($user);

		return $user;
	}
}
