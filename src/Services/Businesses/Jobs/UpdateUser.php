<?php

namespace PragmaRX\Sdk\Services\Businesses\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class UpdateUser extends Job
{
	public $id;

	public $first_name;

	public $last_name;

	public $email;

	public $business_client_id;

	public function handle(BusinessesRepository $businessesRepository)
	{
		return $businessesRepository->updateUser($this->getPublicProperties());
	}
}
