<?php

namespace PragmaRX\Sdk\Services\Passwords\Listeners;

use PragmaRX\Sdk\Services\Passwords\Events\PasswordWasUpdated;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendPasswordUpdatedEmail
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
	 * @param PasswordWasUpdated $event
	 */
	public function handle(PasswordWasUpdated $event)
	{
		$this->userRepository->sendPasswordUpdatedEmail($event->user);
	}
}
