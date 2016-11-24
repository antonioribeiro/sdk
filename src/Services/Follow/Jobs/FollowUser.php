<?php

namespace PragmaRX\Sdk\Services\Follow\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class FollowUser extends Job
{
	public $user_to_follow;

	public $user_id;

	function __construct($user_to_follow, $user_id)
	{
		$this->user_to_follow = $user_to_follow;

		$this->user_id = $user_id;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->follow($this->user_to_follow, $this->user_id);
	}
}
