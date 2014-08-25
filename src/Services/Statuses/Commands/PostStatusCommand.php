<?php

namespace PragmaRX\Sdk\Services\Statuses\Commands;


class PostStatusCommand {

	public $body;

	public $user_id;

	function __construct($body, $user_id)
	{
		$this->body = $body;

		$this->user_id = $user_id;
	}

}
