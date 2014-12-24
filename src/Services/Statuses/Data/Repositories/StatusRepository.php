<?php

namespace PragmaRX\Sdk\Services\Statuses\Data\Repositories;

use ConsultorioDigital\Services\Users\Data\Repositories\User as UserRepository;
use PragmaRX\Sdk\Services\Statuses\Data\Entities\Status;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;

class StatusRepository {

	private $userRepository;

	function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function save(Status $status, $user_id)
	{
		return $this->userRepository->findOrFail($user_id)
				->statuses()
				->save($status);
	}

	public function getAll(User $user = null)
	{
		if ($user)
		{
			return $user->statuses()->with('user')->latest()->get();
		}

		return Status::with('user')->latest()->get();
	}

	public function getFeedForUser($user)
	{
		$userIds = $user->following()->lists('followed_id');

		$userIds[] = $user->id;

		return Status::whereIn('user_id', $userIds)->latest()->get();
	}

}
