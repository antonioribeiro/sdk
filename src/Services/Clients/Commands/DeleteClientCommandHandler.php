<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;

use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class DeleteClientCommandHandler extends CommandHandler {

	/**
	 * @var ClientRepository
	 */
	private $clientRepository;

	function __construct(ClientRepository $clientRepository)
	{
		$this->clientRepository = $clientRepository;
	}

	/**
	 * Handle the command
	 *
	 * @param $command
	 * @return mixed
	 */
	public function handle($command)
	{
		$user = $this->clientRepository->delete(
			$command->user,
			$command->id
		);

		$this->dispatchEventsFor($user);

		return $user;
	}

}
