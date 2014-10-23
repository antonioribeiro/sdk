<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroupMembersCommandHandler extends CommandHandler {

	private $groupRepository;

	function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

    public function handle($command)
    {
		$group = $this->groupRepository->deleteGroupMembers(
			$command->group_id,
			$command->user,
			$command->members,
			$command->administrators
		);

	    $this->dispatchEventsFor($group);

	    return $group;
    }

}
