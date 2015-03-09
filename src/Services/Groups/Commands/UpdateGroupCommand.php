<?php

namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class UpdateGroupCommand extends SelfHandlingCommand {

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
		$group = $groupRepository->updateGroup(
			$this->user,
			$this->name,
			$this->group_id,
			$this->members,
			$this->administrators
		);

		$this->dispatchEventsFor($group);

		return $group;
	}

}

