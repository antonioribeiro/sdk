<?php

namespace PragmaRX\Sdk\Services\Businesses\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class CreateUser extends Job
{
	public $first_name;

	public $last_name;

	public $email;

	public $business_client_id;

	public $business_role_id;

	public function handle(BusinessesRepository $businessesRepository)
	{
		return $businessesRepository->createUser($this->getPublicProperties());
	}
}
