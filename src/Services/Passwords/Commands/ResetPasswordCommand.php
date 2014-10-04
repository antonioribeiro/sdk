<?php

namespace PragmaRX\Sdk\Services\Passwords\Commands;

class ResetPasswordCommand {

	public $email;

	public $username;

	function __construct($email, $username)
	{
		$this->email = $email;

		$this->username = $username;
	}

}
