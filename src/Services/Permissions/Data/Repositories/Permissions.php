<?php

namespace PragmaRX\Sdk\Services\Permissions\Data\Repositories;

use PragmaRX\Sdk\Services\Permissions\Data\Entities\Permission as Model;

class Permissions
{
    public function getAllWithRoles()
    {
        return Model::with('roles')->get();
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
}
