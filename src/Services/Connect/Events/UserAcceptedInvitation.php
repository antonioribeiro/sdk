<?php

namespace PragmaRX\Sdk\Services\Connect\Events;

class UserAcceptedInvitation {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
