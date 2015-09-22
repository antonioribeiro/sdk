<?php

namespace PragmaRX\Sdk\Services\Roles\Data\Repositories;

use PragmaRX\Sdk\Services\Roles\Data\Entities\Roles as Model;

class Roles
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}
}
