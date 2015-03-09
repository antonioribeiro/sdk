<?php

namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroupMembersCommand extends SelfHandlingCommand {

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
		$group = $groupRepository->deleteGroupMembers(
			$this->group_id,
			$this->user,
			$this->members,
			$this->administrators
		);

		$this->dispatchEventsFor($group);

		return $group;
	}

}
