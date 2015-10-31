<?php

namespace PragmaRX\Sdk\Services\Businesses\Events;

class UserWasUpdated
{
	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}
}
