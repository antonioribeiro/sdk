<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddMembersToGroupCommandHandler extends CommandHandler {

	private $groupRepository;

	function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

    public function handle($command)
    {
		$members = $this->groupRepository->addMembersToGroup(
			$command->group_id,
			$command->members
		);

	    foreach($members as $member)
	    {
		    $this->dispatchEventsFor($member);
	    }

	    return $members;
    }

}
