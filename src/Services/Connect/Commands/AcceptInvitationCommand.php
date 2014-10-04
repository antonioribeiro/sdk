<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;


class AcceptInvitationCommand {

	public $user_id;

	function __construct($user_id)
	{
		$this->user_id = $user_id;
	}

}
