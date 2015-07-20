<?php

namespace PragmaRX\Sdk\Services\Clipping\Data\Repositories;

use PragmaRX\Sdk\Services\Clipping\Data\Entities\Clipping as Model;

class Clipping
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}

	public function findPostById($id)
	{
		return Model::findOrFail($id);
	}
}
