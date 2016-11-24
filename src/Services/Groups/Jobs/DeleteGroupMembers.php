<?php

namespace PragmaRX\Sdk\Services\Groups\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroupMembers extends Job
{
	public $user;

	public $group_id;

	public $members;

	public $administrators;

	function __construct($administrators, $group_id, $members, $user)
	{
		$this->administrators = $administrators;

		$this->group_id = $group_id;

		$this->members = $members;

		$this->user = $user;
	}

	public function handle(GroupRepository $groupRepository)
	{
		return $groupRepository->deleteGroupMembers(
            $this->group_id,
            $this->user,
            $this->members,
            $this->administrators
        );
	}
}
