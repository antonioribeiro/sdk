<?php

namespace PragmaRX\SDK\Registration;


class RegisterUserCommand {

	public $first_name;

	public $username;

	public $email;
	
	public $password;

	function __construct($first_name, $username, $email, $password)
	{
		$this->first_name = $first_name;

		$this->username = $username;

		$this->email = $email;

		$this->password = $password;
	}

} 
