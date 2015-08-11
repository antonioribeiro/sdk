<?php

namespace PragmaRX\Sdk\Services\Connect\Listeners;

use PragmaRX\Sdk\Services\Connect\Events\UserWasInvited;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SendInvitationEmail
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
	 * @param UserWasInvited $event
	 */
	public function handle(UserWasInvited $event)
	{
		$this->userRepository->sendInvitationEmail($event->user);
	}
}
