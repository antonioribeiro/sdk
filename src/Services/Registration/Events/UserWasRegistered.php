<?php

namespace PragmaRX\Sdk\Services\Registration\Events;

class UserWasRegistered
{
	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}
}
