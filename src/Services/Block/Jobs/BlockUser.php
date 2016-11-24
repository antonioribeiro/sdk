<?php

namespace PragmaRX\Sdk\Services\Block\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class BlockUser extends Job
{
	public $user_to_block;

	public $user_id;

	function __construct($user_to_block, $user_id)
	{
		$this->user_to_block = $user_to_block;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->block($this->user_to_block, $this->user_id);
	}
}
