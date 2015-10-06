<?php

namespace PragmaRX\Sdk\Services\Products\Data\Repositories;

use PragmaRX\Sdk\Services\Products\Data\Entities\Product;
use PragmaRX\Sdk\Services\Products\Data\Entities\Products as Model;

class Products
{
	public function paginated()
	{
		return Model::orderBy('published_at', 'desc')->paginate(20);
	}

	public function add($properties)
	{
		$product = Product::firstOrCreate([
            'name' => $properties['name'],
            'description' => $properties['description'],
		]);

		return Sku::create([
			'product_id' => $product->id
		]);
	}
}
