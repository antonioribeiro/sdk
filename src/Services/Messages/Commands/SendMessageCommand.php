<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Messages\Data\Repositories\Message as MessageRepository;

class SendMessageCommand extends SelfHandlingCommand {

	public $user;

	public $thread_id;

	public $recipients;

	public $subject;

	public $body;

	public $attachments;

	public $answering_message_id;

	function __construct($attachments, $body, $subject, $recipients, $user, $thread_id, $answering_message_id)
	{
		$this->attachments = $attachments;

		$this->body = $body;

		$this->subject = $subject;

		$this->recipients = $recipients;

		$this->user = $user;

		$this->thread_id = $thread_id;

		$this->answering_message_id = $answering_message_id;
	}

	public function handle(MessageRepository $messageRepository)
	{
		$thread = $messageRepository->sendMessage(
			$this->user,
			$this->thread_id,
			$this->recipients,
			$this->subject,
			$this->body,
			$this->attachments,
			$this->answering_message_id
		);

		$this->dispatchEventsFor($thread);

		Push::fire('inbox', 'new.message', 'This is a message.');
	}

}
