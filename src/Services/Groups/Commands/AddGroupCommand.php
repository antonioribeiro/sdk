<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddGroupCommand extends SelfHandlingCommand {

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
		$user = $groupRepository->addGroup(
			$this->user,
			$this->name,
			$this->members
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
