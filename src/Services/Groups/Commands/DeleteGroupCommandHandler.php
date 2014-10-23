<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class DeleteGroupCommandHandler extends CommandHandler {

	private $groupRepository;

	function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

    public function handle($command)
    {
		$group = $this->groupRepository->deleteGroup(
			$command->group_id,
			$command->user
		);

	    $this->dispatchEventsFor($group);

	    return $group;
    }

}
