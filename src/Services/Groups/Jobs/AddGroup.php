<?php

namespace PragmaRX\Sdk\Services\Groups\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddGroup extends Job
{
	public $user;

	public $name;

	public $members;

	function __construct($user, $name, $members)
	{
		$this->user = $user;

		$this->name = $name;

		$this->members = $members;
	}

	public function handle(GroupRepository $groupRepository)
	{
		return $groupRepository->addGroup(
            $this->user,
            $this->name,
            $this->members
        );
	}
}
