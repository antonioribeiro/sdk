<?php

namespace PragmaRX\SDK\Services\Connect\Commands;

class DisconnectUserCommand {

	public $user_to_disconnect;

	public $user_id;

	function __construct($user_to_disconnect, $user_id)
	{
		$this->user_to_disconnect = $user_to_disconnect;

		$this->user_id = $user_id;
	}

}
