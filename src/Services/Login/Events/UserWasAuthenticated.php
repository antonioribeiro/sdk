<?php

namespace PragmaRX\Sdk\Services\Login\Events;

class UserWasAuthenticated {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
