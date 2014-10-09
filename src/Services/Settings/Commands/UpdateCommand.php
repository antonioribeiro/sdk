<?php

namespace PragmaRX\Sdk\Services\Settings\Commands;


class UpdateCommand {

	public $user;

	public $input;

	function __construct($input, $user)
	{
		$this->input = $input;

		$this->user = $user;
	}

}
