<?php

namespace PragmaRX\Sdk\Services\Roles\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Role extends Model
{
	protected $table = 'permissions';

	protected $presenter = 'PragmaRX\Sdk\Services\Roles\Data\Presenters\Role';

	protected $fillable = [

	];

	public function author()
	{
		return $this->belongsTo(RolesAuthor::class, 'author_id');
	}

}
