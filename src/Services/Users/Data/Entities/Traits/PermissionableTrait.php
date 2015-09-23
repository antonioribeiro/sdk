<?php

namespace PragmaRX\Sdk\Services\Users\Data\Entities\Traits;

use DB;
use PragmaRX\Sdk\Services\Roles\Data\Entities\Role;

trait PermissionableTrait
{
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps();
	}

	public function hasRole($roles)
	{
		if (is_string($roles))
		{
			return $this->roles->contains('name', $roles);
		}

		return !! $roles->intersect($this->roles)->count();
	}

	public function assignRole($role)
	{
		if (is_string($role))
		{
			$role = Role::whereName($role)->firstOrFail();
		}

		$this->roles()->save($role);
	}
}
