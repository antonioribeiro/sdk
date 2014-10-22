<?php namespace PragmaRX\Sdk\Services\Groups\Commands;

use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Groups\Data\Repositories\GroupRepository;

class AddGroupCommandHandler extends CommandHandler {

	private $groupRepository;

	function __construct(GroupRepository $groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

    public function handle($command)
    {
		$user = $this->groupRepository->addGroup(
			$command->user,
			$command->name,
			$command->members
		);

	    $this->dispatchEventsFor($user);

	    return $user;
    }

}
