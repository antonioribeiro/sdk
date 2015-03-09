<?php

namespace PragmaRX\Sdk\Services\Connect\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\Command;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ConnectActionCommand extends SelfHandlingCommand {

	public $user;

	public $connection_id;

	public $action;

	function __construct($action, $connection_id, $user)
	{
		$this->action = $action;

		$this->connection_id = $connection_id;

		$this->user = $user;
	}

	public function handle(UserRepository $userRepository)
	{
		return $userRepository->connectAction(
			$this->user,
			$this->connection_id,
			$this->action
		);
	}

}
