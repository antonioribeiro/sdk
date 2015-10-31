<?php

namespace PragmaRX\Sdk\Services\Activation\Data\Repositories;

use Carbon;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Activation\Data\Entities\Activation as Model;

class Activation {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function completed($user)
	{
		if ( ! $activation = $this->findActivation($user))
		{
			return false;
		}

		return $activation->completed;
	}

	public function isActivated($user)
	{
		return $this->completed($user);
	}

	public function findActivation($user)
	{
		if (is_object($user))
		{
			$user_id = $user->id;
		}
		else
		{
			$user_id = $user;
		}

		if ( ! $activation = Model::where('user_id', $user_id)->first())
		{
			$activation = $this->create($user);
		}

		return $activation;
	}

	public function exists($user)
	{
		return $this->findActivation($user);
	}

	public function activate($user, $token, $force)
	{
		return $this->complete($user, $token, $force);
	}

	public function complete($user, $token, $force)
	{
		if ( ! $activation = $this->findActivation($user))
		{
			return false;
		}

		if ( ! $force && $activation->code != $token)
		{
			return false;
		}

		$activation->completed_at = Carbon::now();

		$activation->completed = true;

		return $activation->save();
	}

	private function create($user)
	{
		if ( ! is_object($user))
		{
			$this->userRepository->find($user);
		}

		return Model::createFor($user);
	}

}
