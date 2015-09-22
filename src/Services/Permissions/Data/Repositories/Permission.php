<?php

namespace PragmaRX\Sdk\Services\Permissions\Data\Repositories;

use PragmaRX\Sdk\Services\Permissions\Data\Entities\Permissions as Model;

class Permissions
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}
}
