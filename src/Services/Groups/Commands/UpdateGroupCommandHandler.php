<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class UpdateGroupCommandHandler extends CommandHandler {

	private $groupRepository;

	function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

    public function handle($command)
    {
		$group = $this->groupRepository->updateGroup(
			$command->user,
			$command->name,
			$command->group_id,
			$command->members,
			$command->administrators
		);

	    $this->dispatchEventsFor($group);

	    return $group;
    }

}
