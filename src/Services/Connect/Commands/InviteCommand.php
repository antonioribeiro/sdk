<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;


class InviteCommand {

	public $user;

	public $emails;

	function __construct($emails, $user)
	{
		$this->emails = $emails;

		$this->user = $user;
	}

}
