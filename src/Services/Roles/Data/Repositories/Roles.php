<?php

namespace PragmaRX\Sdk\Services\Roles\Data\Repositories;

use App\Data\Entities\User;
use PragmaRX\Sdk\Core\Data\Repositories\Repository;
use PragmaRX\Sdk\Services\Roles\Data\Entities\Role as Model;

class Roles extends Repository
{
    protected $model = Model::class;

    public function giveRoleToUser($roleName, $email)
    {
        $role = $this->findByName($roleName);

        $user = User::where('email', $email)->first();

        if (! $user->hasRole($role))
        {
            $user->assignRole($role);
        }
    }

    public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}

    public function create($name, $slug)
    {
        if (! $role = Model::where('name', $name)->first())
        {
            $role = new Model();

            $role->name = $name;
            $role->slug = $slug;

            $role->save();
        }

        return $role;
    }

    public function givePermissionTo($roleName, $permissionName)
    {
        if (is_string($roleName))
        {
            $role = Role::where('name', $roleName)->first();
        }

        if (is_string($permissionName))
        {
            $permission = Permission::where('name', $permissionName)->first();
        }

        return $role;
    }
}
