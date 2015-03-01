<?php

namespace PragmaRX\Sdk\Services\Auth\Service;

use DB;
use Sentinel;
use Reminder;
use Activation;
use Carbon\Carbon;
use PragmaRX\Sdk\Services\Auth\Contracts\Auth as AuthContract;

class SentinelAuth implements AuthContract {

	public function __construct()
	{
	    $this->auth = app('auth');
	}

	public function check()
	{
		return Sentinel::check();
	}

	public function user()
	{
		return $this->check();
	}

	public function guest()
	{
		return Sentinel::guest();
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
		return Sentinel::logout();
	}

	public function authenticate($credentials, $remember = false, $login = true)
	{
		return Sentinel::authenticate($credentials, $remember, $login);
	}

	public function register($credentials)
	{
		return Sentinel::register($credentials);
	}

	public function findByCredentials($credentials)
    {
		return Sentinel::findByCredentials($credentials);
    }

	public function getUserRepository()
    {
		return Sentinel::getUserRepository();
	}

	public function login($user, $remember)
    {
		return Sentinel::login($user, $remember);
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

}
