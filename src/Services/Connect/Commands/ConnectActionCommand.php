<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;


class ConnectActionCommand {

	public $user;

	public $connection_id;

	public $action;

	function __construct($action, $connection_id, $user)
	{
		$this->action = $action;

		$this->connection_id = $connection_id;

		$this->user = $user;
	}


}
