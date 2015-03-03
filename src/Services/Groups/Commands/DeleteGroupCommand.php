<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroupCommand extends SelfHandlingCommand {

	public $user;

	public $group_id;

	function __construct($group_id, $user)
	{
		$this->group_id = $group_id;

		$this->user = $user;
	}

	public function handle(GroupRepository $groupRepository)
	{
		$group = $groupRepository->deleteGroup(
			$this->group_id,
			$this->user
		);

		$this->dispatchEventsFor($group);

		return $group;
	}

}
