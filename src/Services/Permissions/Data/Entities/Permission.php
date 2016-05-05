<?php

namespace PragmaRX\Sdk\Services\Permissions\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Users\Data\Entities\Role;
use PragmaRX\Sdk\Services\Permissions\Data\Presenters\Permission as PermissionPresenter;

class Permission extends Model
{
	protected $table = 'permissions';

	protected $fillable = [];

    protected $presenter = PermissionPresenter::class;

	public function roles()
	{
		return $this
				->belongsToMany(Role::class, 'permissions_roles')
				->withTimestamps();
	}
}
