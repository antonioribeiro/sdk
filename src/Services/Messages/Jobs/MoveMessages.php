<?php

namespace PragmaRX\Sdk\Services\Messages\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class MoveMessages extends Job
{
	public $user;

	public $folder_id;

	public $threads_ids;

	function __construct($folder_id, $threads_ids, $user)
	{
		$this->folder_id = $folder_id;

		$this->threads_ids = $threads_ids;

		$this->user = $user;
	}

	public function handle(MessageRepository $messageRepository)
	{
		return $messageRepository->moveMessages(
			$this->user,
			$this->folder_id,
			$this->threads_ids
		);
	}
}
