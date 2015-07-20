<?php

namespace PragmaRX\Sdk\Services\Tags\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Tags\Data\Repositories\ClientRepository;

class DeleteClientCommand extends SelfHandlingCommand {

	public $id;

	public $user;

	function __construct($id, $user)
	{
		$this->id = $id;

		$this->user = $user;
	}

	public function handle(ClientRepository $clientRepository)
	{
		$user = $clientRepository->delete(
			$this->user,
			$this->id
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
