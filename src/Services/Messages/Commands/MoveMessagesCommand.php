<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Core\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class MoveMessagesCommand extends SelfHandlingCommand {

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
		return $this->messageRepository->moveMessages(
			$this->user,
			$this->folder_id,
			$this->threads_ids
		);
	}

}
