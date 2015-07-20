<?php

namespace PragmaRX\Sdk\Services\Tags\Events;

class UserAcceptedInvitation {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
