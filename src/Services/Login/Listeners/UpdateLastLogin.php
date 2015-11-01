<?php

namespace PragmaRX\Sdk\Services\Login\Listeners;

use PragmaRX\Sdk\Services\Login\Events\UserWasAuthenticated;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UpdateLastLogin
{

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the event.
	 *
	 * @param UserWasAuthenticated $event
	 */
	public function handle(UserWasAuthenticated $event)
	{
		$this->userRepository->updateLastLogin($event->user);
	}
}
