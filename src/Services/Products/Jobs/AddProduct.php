<?php

namespace PragmaRX\Sdk\Services\Products\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Products\Data\Repositories\Products as ProductsRepository;

class AddProduct extends Job
{
	public $name;

	public $description;

	public $cost;

	public $price;

	public $stock;

	public $brand_id;

	public $category_id;

	public $unit_id;

	public function handle(ProductsRepository $productsRepository)
	{
		return $productsRepository->add($this->getPublicProperties());
	}
}
