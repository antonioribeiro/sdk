<?php

namespace PragmaRX\Sdk\Services\Security\Commands;

class RequestToggleEmailCommand {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
