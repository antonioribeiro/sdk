<?php

namespace PragmaRX\SDK\Auth;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Service {

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

}
