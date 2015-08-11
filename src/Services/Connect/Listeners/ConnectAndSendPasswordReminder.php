<?php

namespace PragmaRX\Sdk\Services\Connect\Listeners;

use PragmaRX\Sdk\Services\Bus\Events\DispatchableTrait;
use PragmaRX\Sdk\Services\Connect\Events\UserAcceptedInvitation;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ConnectAndSendPasswordReminder
{
	use DispatchableTrait;

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
	 * @param UserAcceptedInvitation $event
	 */
	public function handle(UserAcceptedInvitation $event)
	{
		$inviterId = $event->user->inviter ? $event->user->inviter->id : null;

		if ($inviterId)
		{
			// Establish a connection between the users
			$this->userRepository->connect($event->user->username, $inviterId, true);
		}

		// Send a password reminder to the new user
		$user = $this->userRepository->sendPasswordReminder($event->user);

		$this->dispatchEventsFor($user);
	}
}
