<?php

namespace PragmaRX\Sdk\Services\Passwords\Commands;

class UpdatePasswordCommand {

	public $email;

	public $password;

	public $token;

	function __construct($email, $password, $token)
	{
		$this->email = $email;

		$this->password = $password;

		$this->token = $token;
	}

}
