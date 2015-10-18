<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;

trait BusinessableTrait
{
	public function businessRoles()
	{
		return $this->hasMany(BusinessClientUserRole::class)
				->with('role')
				->with('user')
				->with('client')
				->join('business_clients', 'business_clients.id', '=', 'business_client_user_roles.business_client_id')
				->join('business_roles', 'business_roles.business_id', '=', 'business_clients.business_id')
				->orderBy('business_roles.power')
		;
	}
}
