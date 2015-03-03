<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class ReadMessageCommand extends SelfHandlingCommand {

	public $thread_id;

	public $user;

	function __construct($user, $thread_id)
	{
		$this->thread_id = $thread_id;

		$this->user = $user;
	}

	public function handle(MessageRepository $messageRepository)
	{
		$thread = $messageRepository->readMessage(
			$this->user,
			$this->thread_id
		);

		$this->dispatchEventsFor($thread);

		return $thread;
	}

}
