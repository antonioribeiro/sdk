<?php

namespace PragmaRX\SDK\Block;


class BlockUserCommand {

	public $user_to_block;

	public $user_id;

	function __construct($user_to_block, $user_id)
	{
		$this->user_to_block = $user_to_block;

		$this->user_id = $user_id;
	}

}
