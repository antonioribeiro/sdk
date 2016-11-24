<?php

namespace PragmaRX\Sdk\Services\Messages\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class AddFolder extends Job
{
	public $user;

	public $folder_name;

	function __construct($folder_name, $user)
	{
		$this->folder_name = $folder_name;

		$this->user = $user;
	}

	public function handle(MessageRepository $messageRepository)
	{
		return $messageRepository->addFolder(
            $this->user,
            $this->folder_name
        );
	}
}
