<?php namespace PragmaRX\Sdk\Services\TwoFactor\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class SignInCommand extends SelfHandlingCommand {

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

	public function handle(UserRepository $userRepository)
	{
		$user = $userRepository->authenticateViaTwoFactor(
			$this->user_id,
			$this->remember,
			$this->authentication_code,
			$this->two_factor_google_token,
			$this->two_factor_sms_token,
			$this->two_factor_email_token
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
