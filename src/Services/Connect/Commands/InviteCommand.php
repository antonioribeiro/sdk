<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class InviteCommand extends SelfHandlingCommand {

	public $user;

	public $emails;

	function __construct($emails, $user)
	{
		$this->emails = $emails;

		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->inviteUsers(
			$this->user,
			$this->emails
		);

		$this->dispatchEventsFor($user);
	}

}
