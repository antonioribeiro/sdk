<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use Push;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class SendMessageCommandHandler extends CommandHandler {

	/**
	 * @var MessageRepository
	 */
	private $messageRepository;

	function __construct
	{
		$this->messageRepository = $messageRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $this
	 * @return mixed
	 */


}
