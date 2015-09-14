<?php

namespace PragmaRX\Sdk\Services\Registration\Service;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Services\Registration\Events\UserWasRegistered;

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

		$user = User::firstOrCreate($credentials);

		event(new UserWasRegistered($user));

		return $user;
	}
}
