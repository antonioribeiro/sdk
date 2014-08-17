<?php

namespace PragmaRX\SDK\Core\Events;

abstract class UserEvent {

	public $user;

	function __construct($user)
	{
		$this->user = $user;
	}

}
