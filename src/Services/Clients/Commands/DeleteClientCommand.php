<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;


class DeleteClientCommand {

	public $id;

	public $user;

	function __construct($id, $user)
	{
		$this->id = $id;

		$this->user = $user;
	}

}
