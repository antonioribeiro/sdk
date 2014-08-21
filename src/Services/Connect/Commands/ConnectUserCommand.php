<?php

namespace PragmaRX\SDK\Services\Connect\Commands;


class ConnectUserCommand {

	public $user_to_connect;

	public $user_id;

	function __construct($user_to_connect, $user_id)
	{
		$this->user_to_connect = $user_to_connect;

		$this->user_id = $user_id;
	}

}
