<?php

namespace PragmaRX\Sdk\Services\Passwords\Listeners;

use PragmaRX\Sdk\Services\Passwords\Events\PasswordReminderCreated;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendPasswordReminderEmail
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
	 * @param PasswordReminderCreated $event
	 */
	public function handle(PasswordReminderCreated $event)
	{
		$this->userRepository->sendPasswordReminderEmail($event->user, $event->token);
	}
}
