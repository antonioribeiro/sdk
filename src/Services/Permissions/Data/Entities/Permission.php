<?php

namespace PragmaRX\Sdk\Services\Permissions\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Permission extends Model
{
	protected $table = 'permissions';

	protected $presenter = 'PragmaRX\Sdk\Services\Permissions\Data\Presenters\Permission';

	protected $fillable = [

	];

	public function author()
	{
		return $this->belongsTo(PermissionsAuthor::class, 'author_id');
	}

}
