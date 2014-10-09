<?php

namespace PragmaRX\Sdk\Services\Clients\Events;

class UserWasInvited {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
