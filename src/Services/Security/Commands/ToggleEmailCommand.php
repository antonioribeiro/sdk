<?php

namespace PragmaRX\Sdk\Services\Security\Commands;

class ToggleEmailCommand {

	public $user;

	public $code;

	function __construct($user, $code)
	{
		$this->user = $user;

		$this->code = $code;
	}

}
