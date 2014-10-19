<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Repositories;

use PragmaRX\Sdk\Services\Clients\Data\Entities\Client;
use PragmaRX\Sdk\Services\Clients\Data\Entities\ProviderClient;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;

class ClientRepository {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function create($provider, $first_name, $last_name, $email)
	{
		$user = $this->findOrCreateUser($first_name, $last_name, $email);

		$client = ProviderClient::create([
			'provider_id' => $provider->id,
			'client_id' => $user->id,
		]);

		return $client;
	}

	private function findOrCreateUser($first_name, $last_name, $email)
	{
		if ( ! $email || ! $user = $this->userRepository->findByEmail($email))
		{
			$user = $this->userRepository->createNonAccount($email, $first_name, $last_name);
		}

		return $user;
	}

	public function update($user, $client_id, $first_name, $last_name, $email, $notes)
	{
		$client = $this->userRepository->findById($client_id);

		if ( ! $client->isActivated)
		{
			$client = $this->updateClientUser($client, $first_name, $last_name, $email);
		}

		return $this->updateClientData($user, $client_id, $notes);
	}

	private function updateClientUser($client, $first_name, $last_name, $email)
	{
		if ($email != $client->email)
		{
			if ($user = $this->userRepository->findByEmail($email))
			{
				return $user;
			}
		}

		$client->first_name = $first_name;

		$client->last_name = $last_name;

		$client->save();

		return $client;
	}

	/**
	 * @param $user
	 * @param $client_id
	 * @param $notes
	 */
	private function updateClientData($user, $client_id, $notes)
	{
		$providerClient = ProviderClient::where('provider_id', $user->id)->where('client_id', $client_id)->first();

		/// We may be changing the current user to an activated user

		$providerClient->client_id = $user->id;

		$providerClient->notes = $notes;

		$providerClient->save();

		return $user;
	}

	public function clientsFromProvider($user)
	{
		return Client::havingAsProvider($user)->get();
	}

	public function findClientById($provider_id, $client_id)
	{
		return Client::where('users.id', $client_id)
				->where('providers_clients.provider_id', $provider_id)->first();
	}

}
