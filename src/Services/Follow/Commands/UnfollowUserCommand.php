<?php
/**
 * Created by PhpStorm.
 * User: AntonioCarlos
 * Date: 29/07/2014
 * Time: 20:12
 */

namespace PragmaRX\Sdk\Services\Follow\Commands;


class UnfollowUserCommand {

	public $user_to_unfollow;

	public $user_id;

	function __construct($user_to_unfollow, $user_id)
	{
		$this->user_to_unfollow = $user_to_unfollow;

		$this->user_id = $user_id;
	}

}
