<?php

namespace PragmaRX\Sdk\Services\Activation\Service;

use PragmaRX\Sdk\Services\Activation\Exceptions\UserNotActivated;
use PragmaRX\Sdk\Services\Activation\Data\Repositories\Activation as ActivationRepository;

class Activation {

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

}
