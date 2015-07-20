<?php

namespace PragmaRX\Sdk\Services\Tags\Events;

class UserWasInvited {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
