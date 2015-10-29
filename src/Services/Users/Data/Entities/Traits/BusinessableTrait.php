<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
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
}
