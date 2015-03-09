<?php

namespace PragmaRX\Sdk\Services\Clients\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;

class UpdateClientCommand extends SelfHandlingCommand {

	public $id;

	public $user;

	public $first_name;

	public $last_name;

	public $email;

	public $notes;

	public $color;

	public $birthdate;

	function __construct($email, $first_name, $id, $last_name, $user, $notes, $color, $birthdate)
	{
		$this->email = $email;

		$this->first_name = $first_name;

		$this->id = $id;

		$this->last_name = $last_name;

		$this->user = $user;

		$this->notes = $notes;

		$this->color = $color;

		$this->birthdate = $birthdate;
	}

	public function handle(ClientRepository $clientRepository)
	{
		$client = $clientRepository->update(
			$this->user,
			$this->id,
			$this->first_name,
			$this->last_name,
			$this->email,
			$this->notes,
			$this->color,
			$this->birthdate
		);

		$this->dispatchEventsFor($client);

		return $client;
	}

}
