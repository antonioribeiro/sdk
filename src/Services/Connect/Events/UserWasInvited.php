<?php

namespace PragmaRX\Sdk\Services\Connect\Events;

class UserWasInvited {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
