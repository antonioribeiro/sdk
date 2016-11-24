<?php

namespace PragmaRX\Sdk\Services\Groups\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroup extends Job
{
	public $user;

	public $group_id;

	function __construct($group_id, $user)
	{
		$this->group_id = $group_id;

		$this->user = $user;
	}

	public function handle(GroupRepository $groupRepository)
	{
		return $groupRepository->deleteGroup(
            $this->group_id,
            $this->user
        );
	}
}
