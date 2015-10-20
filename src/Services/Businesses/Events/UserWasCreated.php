<?php

namespace PragmaRX\Sdk\Services\Businesses\Events;

class UserWasCreated
{
	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}
}
