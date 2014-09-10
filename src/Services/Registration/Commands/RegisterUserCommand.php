<?php

namespace PragmaRX\Sdk\Services\Registration\Commands;


class RegisterUserCommand {

	public $id;

	public $username;

	public $email;
	
	public $password;

	public $first_name;

	public $last_name;

	function __construct($id, $username, $email, $password, $first_name, $last_name)
	{
		$this->id = $id;

		$this->username = $username;

		$this->email = $email;

		$this->password = $password;

		$this->first_name = $first_name;

		$this->last_name = $last_name;
	}

} 
