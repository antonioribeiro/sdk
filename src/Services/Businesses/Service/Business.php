<?php

namespace PragmaRX\Sdk\Services\Businesses\Service;

use Auth;
use Session;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Business
{
	const CURRENT_BUSINESS_SESSION_KEY = 'current-business';
	const CURRENT_BUSINESS_CLIENT_SESSION_KEY = 'current-business-client';

	private $current = null;

	private $currentClient = null;

	private $businessesRepository;

	private $allMade = false;

	public function __construct(BusinessesRepository $businessesRepository)
	{
		$this->businessesRepository = $businessesRepository;
	}

	public function makeCurrent()
	{
		if ($this->current || $this->current = Session::get(static::CURRENT_BUSINESS_SESSION_KEY))
		{
			return $this->current;
		}

		if ( ! $user = Auth::user())
		{
			return null;
		}

		if ($user->preferred_business_id)
		{
			return $this->setCurrent(
				$this->businessesRepository->findById($user->preferred_business_id)
			);
		}

		$role = $user ? $user->businessRole : null;

		$current = null;

		if ($role && $role->business)
		{
			$current = $role->business;
		}
		else
		{
			if ( ! $current = $this->businessesRepository->getFirst())
			{
				$current = $this->businessesRepository->getNewModel();
			}
		}

		if ($this->allowedToCurrentUser($current))
		{
			return $this->setCurrent($current);
		}

		if ($this->isCleared())
		{
			$this->clear();

			$current = $this->makeCurrent();
		}

		return $current;
	}

	public function getCurrent()
	{
		return $this->current;
	}

	public function setCurrent($business)
	{
		if ($this->current && $business->id !== $this->current->id)
		{
			$this->clearAll();
		}

		if ( ! is_object($business))
		{
			$business = $this->businessesRepository->findById($business);
		}

		Session::put(static::CURRENT_BUSINESS_SESSION_KEY, $business);

		if ($user = Auth::user())
		{
			$user->preferred_business_id = $business->id;

			$user->save();
		}

		return $this->current = $business;
	}

	public function getAll()
	{
		return $this->businessesRepository->all() ?: [];
	}

	public function getAllExceptCurrent()
	{
		$businesses = [];

		$current = $this->getCurrent();

		foreach ($this->getAll() as $business)
		{
			if ( ! $current || $business->id !== $current->id)
			{
				$businesses[] = $business;
			}
		}

		return $businesses;
	}

	private function clear()
	{
		$this->current = null;

		Session::forget(static::CURRENT_BUSINESS_SESSION_KEY);

		$this->clearClient();
	}

	private function allowedToCurrentUser($business)
	{
		if ( ! $user = Auth::user())
		{
			return false;
		}

		if ($user->is_root || ! $business)
		{
			return true;
		}

		$userBusinesses = $user->businesses;

		if ( ! $userBusinesses || $userBusinesses->count() == 0)
		{
			return false;
		}

		return $userBusinesses->contains($business->id);
	}

	public function getCurrentClient()
	{
		return $this->currentClient;
	}

	public function makeCurrentClient()
	{
		if ( ! $user = Auth::user())
		{
			return null;
		}

		if ( ! $client = $this->currentClient)
		{
			$client = Session::get(static::CURRENT_BUSINESS_CLIENT_SESSION_KEY);
		}

		if ( ! $client && $client = $user->preferred_business_client_id)
		{
			$client = $this->businessesRepository->findClientById($client);
		}

		if ( ! $client)
		{
			$client = $this->getFirstAvailableClient();
		}

		if ($client)
		{
			if (! $this->clientAllowedToCurrentUser($client) || ! $this->clientBelongsToCurrentBusiness($client))
			{
				if ( ! $client = $this->getFirstAvailableClient())
				{
					if ( ! $this->isClientCleared())
					{
						$this->clearClient();

						$this->makeCurrentClient();
					}
				}
			}
		}

		if ($client)
		{
			return $this->setCurrentClient($client);
		}

		return $this->setCurrentClient(
			$this->businessesRepository->getNewClientModel()
		);
	}

	public function setCurrentClient($client)
	{
		if ( ! is_object($client))
		{
			$client = $this->businessesRepository->findClientById($client);
		}

		Session::put(static::CURRENT_BUSINESS_CLIENT_SESSION_KEY, $client);

		if ($user = Auth::user())
		{
			$user->preferred_business_client_id = $client->id;

			$user->save();
		}

		return $this->currentClient = $client;
	}

	public function getAllClients()
	{
		if ( ! $current = $this->getCurrent())
		{
			return [];
		}

		return $current->clients;
	}

	public function getAllClientsExceptCurrent()
	{
		$clients = [];

		$current = $this->getCurrentClient();

		foreach ($this->getAllClients() as $client)
		{
			if ( ! $current || $client->id !== $current->id)
			{
				$clients[] = $client;
			}
		}

		return $clients;
	}

	private function clientAllowedToCurrentUser($client)
	{
		$user = Auth::user();

		if ($user->is_root && $client)
		{
			return true;
		}

		$userClients = $user->clients;

		if ( ! $userClients || $userClients->count() == 0)
		{
			return false;
		}

		return $userClients->contains($client->id);
	}

	private function clearClient()
	{
		$this->currentClient = null;

		Session::forget(static::CURRENT_BUSINESS_CLIENT_SESSION_KEY);
	}

	public function makeAll()
	{
		if ( ! $this->allMade)
		{
			$this->makeCurrent();

			$this->makeCurrentClient();

			$this->allMade = true;
		}
	}

	private function isCleared()
	{
		return ! $this->current;
	}

	private function isClientCleared()
	{
		return ! $this->currentClient;
	}

	private function clientBelongsToCurrentBusiness($client)
	{
		return $client && $this->getCurrent()->clients->contains($client->id);
	}

	private function clearAll()
	{
		$this->clear();

		$this->clearClient();
	}

	private function getFirstAvailableClient()
	{
		foreach ($this->getCurrent()->clients as $client)
		{
			if ($this->clientAllowedToCurrentUser($client) && $this->clientBelongsToCurrentBusiness($client))
			{
				return $client;
			}
		}

		return null;
	}
}
