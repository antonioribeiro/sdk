<?php

namespace PragmaRX\Sdk\Services\Activation\Service;

use PragmaRX\Sdk\Services\Activation\Data\Repositories\Activation as ActivationRepository;

class Activation
{
	/**
	 * @var ActivationRepository
	 */
	private $activationRepository;

	public function __construct(ActivationRepository $activationRepository)
	{
		$this->activationRepository = $activationRepository;
	}

	public function activated($user)
	{
		return $this->activationRepository->isActivated($user);
	}

	public function completed($user)
	{
		return $this->activated($user);
	}

	public function complete($user, $token, $force = false)
	{
		return $this->activationRepository->activate($user, $token, $force);
	}

	public function exists($user)
	{
		return $this->activationRepository->exists($user);
	}
}
