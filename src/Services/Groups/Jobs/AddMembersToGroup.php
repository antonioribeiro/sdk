<?php

namespace PragmaRX\Sdk\Services\Groups\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddMembersToGroup extends Job
{
	public $user;

	public $group_id;

	public $members;

	function __construct($user, $group_id, $members)
	{
		$this->user = $user;

		$this->group_id = $group_id;

		$this->members = $members;
	}

	public function handle(GroupRepository $groupRepository)
	{
		return $this->groupRepository->addMembersToGroup(
            $this->group_id,
            $this->members
        );
	}
}
