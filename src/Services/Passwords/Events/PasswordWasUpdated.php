<?php

namespace PragmaRX\Sdk\Services\Passwords\Events;

class PasswordWasUpdated {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
