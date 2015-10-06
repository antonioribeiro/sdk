<?php

namespace PragmaRX\Sdk\Services\Products\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Products\Data\Repositories\Products as ProductsRepository;

class AddProduct extends SelfHandlingCommand
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
		$this->dispatchEventsFor(
			$result = $productsRepository->add($this->getPublicProperties())
		);

		return $result;
	}
}
