<?php

namespace PragmaRX\Sdk\Services\Settings\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UpdateCommand extends SelfHandlingCommand {

	public $user;

	public $input;

	function __construct($input, $user)
	{
		$this->input = $input;

		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->updateSettings($this->user, $this->input);

		$this->dispatchEventsFor($user);
	}

}
