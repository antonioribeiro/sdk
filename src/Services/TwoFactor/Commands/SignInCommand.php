<?php namespace PragmaRX\Sdk\Services\TwoFactor\Commands;

class SignInCommand {

	public $user_id;

	public $remember;

	public $two_factor_google_token;

	public $two_factor_sms_token;

	public $two_factor_email_token;

	public $authentication_code;

	function __construct(
		$authentication_code,
		$remember,
		$two_factor_email_token,
		$two_factor_google_token,
		$two_factor_sms_token,
		$user_id
	)
	{
		$this->authentication_code = $authentication_code;
		$this->remember = $remember;
		$this->two_factor_email_token = $two_factor_email_token;
		$this->two_factor_google_token = $two_factor_google_token;
		$this->two_factor_sms_token = $two_factor_sms_token;
		$this->user_id = $user_id;
	}

}
