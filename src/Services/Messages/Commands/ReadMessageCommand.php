<?php

namespace PragmaRX\Sdk\Services\Messages\Commands;


class ReadMessageCommand {

	public $thread_id;

	public $user;

	function __construct($user, $thread_id)
	{
		$this->thread_id = $thread_id;

		$this->user = $user;
	}

}
