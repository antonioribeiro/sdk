<?php

namespace PragmaRX\Sdk\Services\Passwords\Events;

class PasswordReminderCreated {

	public $user;

	public $token;

	function __construct($user, $token)
	{
		$this->user = $user;

		$this->token = $token;
	}

}
