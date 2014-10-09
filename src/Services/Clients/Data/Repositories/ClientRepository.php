<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Repositories;

class ClientRepository {

	public function create($user, $first_name, $last_name, $email, $mobile_phone)
	{
		$client = Client::create([
            'user_id' => $user->id,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ]);

		dd($client);

		return $user;
	}

}
