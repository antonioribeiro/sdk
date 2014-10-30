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

	public function create($provider, $first_name, $last_name, $email, $birthdate)
	{
		$user = $this->findOrCreateUser($first_name, $last_name, $email);

		$client = ProviderClient::create([
			'provider_id' => $provider->id,
			'client_id' => $user->id,
		    'birthdate' => $birthdate
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

	public function update($user, $client_id, $first_name, $last_name, $email, $notes, $color, $birthdate)
	{
		$client = $this->userRepository->findById($client_id);

		if ( ! $client->isActivated)
		{
			$client = $this->updateClientUser($client, $first_name, $last_name, $email);
		}

		return $this->updateClientData($user, $client, $client_id, $notes, $color, $birthdate);
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
	private function updateClientData($user, $client, $client_id, $notes, $color, $birthdate)
	{
		$providerClient = ProviderClient::where('provider_id', $user->id)->where('client_id', $client_id)->first();

		/// We may be changing the current user to an activated user

		$providerClient->client_id = $client->id;

		$providerClient->notes = $notes;

		$providerClient->color = $color;

		$providerClient->birthdate = $birthdate;

		$providerClient->save();

		return $client;
	}

	public function clientsFromProvider($user)
	{
		return Client::havingAsProvider($user)->get();
	}

	public function findClientById($provider_id, $provider_client_id)
	{
		return Client::where('providers_clients.client_id', $provider_client_id)
				->where('providers_clients.provider_id', $provider_id)
				->first();
	}

	public function delete($provider, $provider_client_id)
	{
		$providerClient = ProviderClient::where('provider_id', $provider->id)
							->where('id', $provider_client_id)->first();

		$client = $this->userRepository->findById($providerClient->client_id);

		if ( ! $client->isActivated)
		{
			$client->delete();
		}

		$providerClient->delete();

		return $provider;
	}

}
