<?php

namespace PragmaRX\Sdk\Services\Auth\Service;

use DB;
use Activation;
use Carbon\Carbon;
use PragmaRX\Sdk\Services\Auth\Exceptions\UserNotActivated;
use PragmaRX\Sdk\Services\Auth\Contracts\Auth as AuthContract;

class IlluminateAuth implements AuthContract {

	public function __construct()
	{
	    $this->auth = app('auth');
	}

	public function check()
	{
		return $this->auth->check();
	}

	public function user()
	{
		return $this->auth->user();
	}

	public function guest()
	{
		return $this->auth->guest();
	}

	public function id()
	{
		if ($user = $this->user())
		{
			return $user->id;
		}

		return false;
	}

	public function logout()
	{
		return $this->auth->logout();
	}

	public function authenticate($user, $remember = false, $login = true)
	{
		$this->checkActivation($user);

		if ( ! $login)
		{
			return true;
		}

		return $this->auth->login($user, $remember);
	}

	public function register($credentials)
	{
		return $this->auth->register($credentials);
	}

	public function findByCredentials($credentials)
    {
		return $this->auth->getProvider()->retrieveByCredentials(
			$this->sanitizeCredentials($credentials)
		);
    }

	public function getUserRepository()
    {
		return $this->auth->getUserRepository();
	}

	public function login($user, $remember)
    {
		return $this->auth->login($user, $remember);
    }

	public function createReminder($user)
    {
		return Reminder::create($user);
    }

	public function updatePasswordViaReminder($user, $token, $password)
	{
		return Reminder::complete($user, $token, $password);
	}

	public function forceActivation($user)
	{
		$this->checkAndCreateActivation($user);

		DB::table('activations')
			->where('user_id', $user->id)
			->update([
		         'completed' => true,
		         'completed_at' => Carbon::now()
	        ]);
	}

	public function checkAndCreateActivation($user)
	{
		if ( ! Activation::exists($user))
		{
			Activation::create($user);

			return true;
		}

		return false;
	}

	private function sanitizeCredentials($credentials)
	{
		return [
			'email' => $credentials['email'],
			'password' => $credentials['password'],
        ];
	}

	public function hasValidCredentials($user, $credentials)
	{
		return
			! is_null($user) &&
			$this->auth->getProvider()->validateCredentials($user, $credentials);
	}

	private function checkActivation($user)
	{
		if ( ! Activation::activated($user))
		{
			throw new UserNotActivated();
		}
	}

}
