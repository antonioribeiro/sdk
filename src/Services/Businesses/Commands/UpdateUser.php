<?php

namespace PragmaRX\Sdk\Services\Businesses\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class UpdateUser extends SelfHandlingCommand
{
	public $id;

	public $first_name;

	public $last_name;

	public $email;

	public $business_client_id;

	public function handle(BusinessesRepository $businessesRepository)
	{
		$this->dispatchEventsFor(
			$result = $businessesRepository->updateUser($this->getPublicProperties())
		);

		return $result;
	}
}
