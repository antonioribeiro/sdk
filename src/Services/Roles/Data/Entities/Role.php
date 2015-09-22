<?php

namespace PragmaRX\Sdk\Services\Roles\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Permissions\Data\Entities\Permission;

class Role extends Model
{
	protected $table = 'permissions';

	protected $presenter = 'PragmaRX\Sdk\Services\Roles\Data\Presenters\Role';

	protected $fillable = [

	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permission_role');
	}

	public function givePermissionTo(Permission $permission)
	{
		return $this->permissions()->save($permission);
	}
}
