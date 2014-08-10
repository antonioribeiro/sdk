<?php namespace PragmaRX\SDK\Accounts;

class SignInCommand {

	/**
	 * @var
	 */
	public $email;

	/**
	 * @var
	 */
	public $password;


	/**
	 * @param $email
	 * @param $password
	 */
	function __construct($email, $password)
	{
		$this->email = $email;

		$this->password = $password;
	}

}
