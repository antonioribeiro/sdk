<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class SendMessageCommandHandler extends CommandHandler {

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
		$thread = $this->messageRepository->sendMessage(
			$command->user,
			$command->thread_id,
			$command->recipients,
			$command->subject,
			$command->body,
			$command->attachments,
			$command->answering_message_id
		);

		$this->dispatchEventsFor($thread);
	}

}
