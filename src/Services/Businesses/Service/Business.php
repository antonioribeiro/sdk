<?php

namespace PragmaRX\Sdk\Services\Businesses\Service;

use Auth;
use Session;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Business
{
	const CURRENT_BUSINESS_SESSION_KEY = 'current.business';

	private $current = null;

	private $businessesRepository;

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

		if ($role && $role->business)
		{
			$this->current = $role->business;
		}
		else
		{
			if ( ! $this->current = $this->businessesRepository->getFirst())
			{
				$this->current = $this->businessesRepository->getNewModel();
			}
		}

		return $this->setCurrent($this->current);
	}

	public function getCurrent()
	{
		$business = $this->makeCurrent();

		if ( ! $this->allowedToCurrentUser($business))
		{
			$this->clear();

			$business = $this->makeCurrent();
		}

		return $business;
	}

	public function setCurrent($business)
	{
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

		foreach ($this->getAll() as $business)
		{
			if ($business->id !== $this->getCurrent()->id)
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
	}

	private function allowedToCurrentUser($business)
	{
		if ( ! $user = Auth::user())
		{
			return false;
		}

		if ($user->is_root)
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
}
