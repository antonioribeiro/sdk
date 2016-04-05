<?php

namespace PragmaRX\Sdk\Services\Login\Events;

class UserWasLoggedOut
{
	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}
}
