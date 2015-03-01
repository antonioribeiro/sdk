<?php

namespace PragmaRX\Sdk\Services\Activation\Data\Repositories;

use PragmaRX\Sdk\Services\Activation\Data\Entities\Activation as Model;

class Activation {

	public function isActivated($user)
	{
		if ( ! $activation = $this->findActivation($user))
		{
			$this->createActivation($user);

			return false;
		}

		return $activation->completed;
	}

	private function findActivation($user)
	{
		if (is_object($user))
		{
			$user = $user->id;
		}

		return Model::where('user_id', $user)->first();
	}

	private function createActivation($user)
	{
		return Model::createFor($user);
	}

}
