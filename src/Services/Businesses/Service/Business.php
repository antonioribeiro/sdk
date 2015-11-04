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

		$role = Auth::user()->businessRole;

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
		return $this->makeCurrent();
	}

	public function setCurrent($business)
	{
		if ( ! is_object($business))
		{
			$business = $this->businessesRepository->findById($business);
		}

		Session::put(static::CURRENT_BUSINESS_SESSION_KEY, $business);

		return $this->current = $business;
	}

	public function getAll()
	{
		return $this->businessesRepository->all();
	}
}
