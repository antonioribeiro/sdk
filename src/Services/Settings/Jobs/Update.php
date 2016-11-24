<?php

namespace PragmaRX\Sdk\Services\Settings\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class Update extends Job
{
	public $user;

	public $input;

	function __construct($input, $user)
	{
		$this->input = $input;

		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->updateSettings($this->user, $this->input);
	}
}
