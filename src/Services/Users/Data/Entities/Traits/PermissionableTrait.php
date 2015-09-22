<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
use PragmaRX\Sdk\Services\Users\Data\Entities\Role;

trait PermissionableTrait
{
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}
}
