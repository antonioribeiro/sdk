<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;

trait BusinessableTrait
{
	public function businessClientRoles()
	{
		$relation = $this->hasMany(BusinessClientUserRole::class, 'user_id')
						->with('role')
						->with('user')
						->with('client')
						->join('business_clients', 'business_clients.id', '=', 'business_client_user_roles.business_client_id')
		;

		return $relation;
	}
}
