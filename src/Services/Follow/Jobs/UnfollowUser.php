<?php

namespace PragmaRX\Sdk\Services\Follow\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class UnfollowUser extends Job
{
	public $user_to_unfollow;

	public $user_id;

	function __construct($user_to_unfollow, $user_id)
	{
		$this->user_to_unfollow = $user_to_unfollow;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->unfollow($this->user_to_unfollow, $this->user_id);
	}
}
