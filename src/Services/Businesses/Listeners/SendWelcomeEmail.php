<?php

namespace PragmaRX\Sdk\Services\Businesses\Listeners;

use PragmaRX\Sdk\Services\Businesses\Events\UserWasCreated;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendWelcomeEmail
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
	 * @param UserWasCreated $event
	 */
	public function handle(UserWasCreated $event)
	{
		$this->userRepository->sendWelcomeEmail($event->user);
	}
}
