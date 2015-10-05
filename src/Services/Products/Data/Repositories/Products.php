<?php

namespace PragmaRX\Sdk\Services\Products\Data\Repositories;

use PragmaRX\Sdk\Services\Products\Data\Entities\Products as Model;

class Products
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}

	public function add($properties)
	{
		dd($properties);
	}
}
