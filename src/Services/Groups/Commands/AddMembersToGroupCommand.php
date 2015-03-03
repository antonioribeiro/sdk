<?php

namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddMembersToGroupCommand extends SelfHandlingCommand {

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
		$members = $this->groupRepository->addMembersToGroup(
			$this->group_id,
			$this->members
		);

		foreach($members as $member)
		{
			$this->dispatchEventsFor($member);
		}

		return $members;
	}
}
