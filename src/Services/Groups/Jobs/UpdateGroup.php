<?php

namespace PragmaRX\Sdk\Services\Groups\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class UpdateGroup extends Job
{
	public $user;

	public $name;

	public $group_id;

	public $members;

	public $administrators;

	function __construct($administrators, $group_id, $members, $name, $user)
	{
		$this->administrators = $administrators;

		$this->group_id = $group_id;

		$this->members = $members;

		$this->name = $name;

		$this->user = $user;
	}

	public function handle(GroupRepository $groupRepository)
	{
		return $groupRepository->updateGroup(
            $this->user,
            $this->name,
            $this->group_id,
            $this->members,
            $this->administrators
        );
	}
}
