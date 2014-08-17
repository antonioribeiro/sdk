<?php

namespace PragmaRX\SDK\Block;

class UnblockUserCommand {

	public $user_to_unblock;

	public $user_id;

	function __construct($user_to_unblock, $user_id)
	{
		$this->user_to_unblock = $user_to_unblock;

		$this->user_id = $user_id;
	}

}
