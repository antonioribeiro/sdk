<?php

namespace PragmaRX\Sdk\Services\Registration\Service;

use App\Services\Users\Data\Entities\User;

class Registration
{
	public function __construct()
	{

	}

	public function register($credentials)
	{
		if ($user = User::where('email', $credentials['email'])->first() )
		{
			return $user;
		}

		return User::firstOrCreate($credentials);
	}
}
