<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Repositories;

use PragmaRX\Sdk\Services\Clients\Data\Entities\Client;

class ClientRepository {

	public function create($user, $first_name, $last_name, $email, $mobile_phone)
	{
		$client = Client::create([
			'provider_id' => $user->id,
			'first_name' => $first_name,
			'last_name' => $last_name,
		]);

		return $client;
	}

}
