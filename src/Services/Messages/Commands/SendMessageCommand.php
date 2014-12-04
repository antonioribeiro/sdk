<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;


class SendMessageCommand {

	public $user;

	public $thread_id;

	public $recipients;

	public $subject;

	public $body;

	public $attachments;

	function __construct($attachments, $body, $subject, $recipients, $user, $thread_id)
	{
		$this->attachments = $attachments;

		$this->body = $body;

		$this->subject = $subject;

		$this->recipients = $recipients;

		$this->user = $user;

		$this->thread_id = $thread_id;
	}

}
