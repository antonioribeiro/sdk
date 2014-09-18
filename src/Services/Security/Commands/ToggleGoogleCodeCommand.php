<?php

namespace PragmaRX\Sdk\Services\Security\Commands;

class ToggleGoogleCodeCommand {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
