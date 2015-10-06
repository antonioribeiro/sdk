<?php

namespace PragmaRX\Sdk\Services\Products\Data\Repositories;

use PragmaRX\Sdk\Services\Products\Data\Entities\Product;
use PragmaRX\Sdk\Services\Products\Data\Entities\Products as Model;
use PragmaRX\Sdk\Services\Products\Data\Entities\Sku;

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
            'brand_id' => $properties['brand_id'],
            'category_id' => $properties['category_id'],
            'unit_id' => $properties['unit_id'],
		]);

		return Sku::create([
			'product_id' => $product->id
		]);
	}
}
