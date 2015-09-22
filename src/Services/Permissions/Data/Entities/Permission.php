<?php

namespace PragmaRX\Sdk\Services\Permissions\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Users\Data\Entities\Role;

class Permission extends Model
{
	protected $table = 'permissions';

	protected $presenter = 'PragmaRX\Sdk\Services\Permissions\Data\Presenters\Permission';

	protected $fillable = [

	];

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'permission_role');
	}
}
