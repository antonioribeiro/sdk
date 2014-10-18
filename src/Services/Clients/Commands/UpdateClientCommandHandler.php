<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;

use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Commanding\CommandHandler;

class UpdateClientCommandHandler extends CommandHandler {

	protected $userRepository;

	/**
	 * @var ClientRepository
	 */
	private $clientRepository;

	function __construct(UserRepository $userRepository, ClientRepository $clientRepository)
	{
		$this->userRepository = $userRepository;

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
		$client = $this->clientRepository->update(
			$command->user,
			$command->id,
			$command->first_name,
			$command->last_name,
			$command->email,
			$command->notes
		);

		$this->dispatchEventsFor($client);
	}

}
