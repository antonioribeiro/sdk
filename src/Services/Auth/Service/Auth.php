<?php

namespace PragmaRX\Sdk\Services\Auth\Service;

use Sentinel;

class Auth {

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
}
