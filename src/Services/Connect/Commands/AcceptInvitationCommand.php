<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\Command;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class AcceptInvitationCommand extends SelfHandlingCommand {

	public $user_id;

	function __construct($user_id)
	{
		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->acceptInvitation($this->user_id);

		$this->dispatchEventsFor($user);
	}

}
