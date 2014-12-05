<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class ReadMessageCommandHandler extends CommandHandler {

	/**
	 * @var MessageRepository
	 */
	private $messageRepository;

	function __construct(MessageRepository $messageRepository)
	{
		$this->messageRepository = $messageRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		$thread = $this->messageRepository->readMessage(
			$command->user,
			$command->thread_id
		);

		$this->dispatchEventsFor($thread);

		return $thread;
	}

}
