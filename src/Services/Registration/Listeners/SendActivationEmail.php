<?php

namespace PragmaRX\Sdk\Services\Registration\Listeners;

use PragmaRX\Sdk\Services\Registration\Events\UserWasRegistered;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendActivationEmail
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
	 * @param UserWasRegistered $event
	 */
	public function handle(UserWasRegistered $event)
	{
		$this->userRepository->checkAndCreateActivation($event->user);

		$this->userRepository->create2FASecrets($event->user);
	}
}
