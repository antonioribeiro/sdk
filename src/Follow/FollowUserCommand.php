<?php

namespace PragmaRX\SDK\Follow;


class FollowUserCommand {

	public $user_to_follow;

	public $user_id;

	function __construct($user_to_follow, $user_id)
	{
		$this->user_to_follow = $user_to_follow;

		$this->user_id = $user_id;
	}

}
