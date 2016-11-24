<?php

namespace PragmaRX\Sdk\Services\Block\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UnblockUser extends Job
{
	public $user_to_unblock;

	public $user_id;

	function __construct($user_to_unblock, $user_id)
	{
		$this->user_to_unblock = $user_to_unblock;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->unblock($this->user_to_unblock, $this->user_id);
	}
}
