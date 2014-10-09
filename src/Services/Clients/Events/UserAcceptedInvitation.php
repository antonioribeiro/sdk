<?php

namespace PragmaRX\Sdk\Services\Clients\Events;

class UserAcceptedInvitation {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
