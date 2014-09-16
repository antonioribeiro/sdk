<?php namespace PragmaRX\Sdk\Services\TwoFactor\Commands;

class SignInCommand {

	public $user_id;

	public $two_factor_token;

	public $authentication_code;

	function __construct($authentication_code, $two_factor_token, $user_id)
	{
		$this->authentication_code = $authentication_code;

		$this->two_factor_token = $two_factor_token;

		$this->user_id = $user_id;
	}

}
