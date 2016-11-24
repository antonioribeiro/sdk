<?php

namespace PragmaRX\Sdk\Services\Messages\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class ReadMessage extends Job
{
	public $thread_id;

	public $user;

	function __construct($user, $thread_id)
	{
		$this->thread_id = $thread_id;

		$this->user = $user;
	}

	public function handle(MessageRepository $messageRepository)
	{
		return $messageRepository->readMessage(
            $this->user,
            $this->thread_id
        );
	}
}
