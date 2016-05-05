<?php

namespace PragmaRX\Sdk\Services\Roles\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Permissions\Data\Entities\Permission;
use PragmaRX\Sdk\Services\Roles\Data\Presenters\Role as RolePresenter;
class Role extends Model
{
	protected $table = 'roles';

	protected $presenter = RolePresenter::class;

	protected $fillable = [

	];

	public function permissions()
	{
		return $this
				->belongsToMany(Permission::class, 'permissions_roles')
				->withTimestamps();
	}

	public function givePermissionTo(Permission $permission)
	{
		return $this->permissions()->save($permission);
	}
}

//
// $role = new PragmaRX\Sdk\Services\Roles\Data\Entities\Role();
// $role->name = 'create_product';
// $role->slug = 'create_product';
// $role->save();
// $role = PragmaRX\Sdk\Services\Roles\Data\Entities\Role::first();
// $permission = PragmaRX\Sdk\Services\Permissions\Data\Entities\Permission::first();
// $permission = new PragmaRX\Sdk\Services\Permissions\Data\Entities\Permission();
// factory(::class)->create();
// $permission->name = "create_products";
// $permission->slug = "create_products";
// $permission->save();
// $permission->name = "edit_products";
// $permission->slug = "edit_products";
// $role->givePermissionTo($permission);
// $user = App\Services\Users\Data\Entities\User::first();
// $user->roles()->save($role);
