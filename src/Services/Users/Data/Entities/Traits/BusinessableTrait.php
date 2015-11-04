<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessRole;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUser;

trait BusinessableTrait
{
	public function businessClientUsers()
	{
		$relation = $this->hasMany(BusinessClientUser::class, 'user_id')
						->with('client')
						->with('user')
						->with('roles')
		;

		return $relation;
	}

	public function getBusinessRoleAttribute()
	{
		if ($this->is_root)
		{
			$role = new BusinessRole();
			$role->power = 0;
			$role->name = 'root';
			$role->description = 'Root';

			return $role;
		}

		if ($clientUser = $this->businessClientUsers->first())
		{
			$role = $clientUser->roles->first()->role;
		}
		else
		{
			$role = new BusinessRole();
		}

		return $role;
	}

	public function getBusinessClientAttribute()
	{
		$client = null;

		if ($clientUser = $this->businessClientUsers->first())
		{
			$client = $clientUser->client;
		}

		if ( ! $client)
		{
			$client = new BusinessClient();
		}

		return $client;
	}

	
}
