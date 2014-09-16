<?php namespace PragmaRX\Sdk\Services\Accounts\Commands;

class SignInCommand {

	public $email;

	public $password;

	public $remember;

	function __construct($email, $password, $remember)
	{
		$this->email = $email;

		$this->password = $password;

		$this->remember = $remember;
	}

}
