<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class AddFolderCommand extends SelfHandlingCommand {

	public $user;

	public $folder_name;

	function __construct($folder_name, $user)
	{
		$this->folder_name = $folder_name;

		$this->user = $user;
	}

	public function handle(MessageRepository $messageRepository)
	{
		$thread = $messageRepository->addFolder(
			$this->user,
			$this->folder_name
		);

		$this->dispatchEventsFor($thread);

		return $thread;
	}

}
