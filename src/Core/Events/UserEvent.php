<?php

namespace PragmaRX\Sdk\Core\Events;

abstract class UserEvent {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
