<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Brand extends Model
{
	protected $table = 'products_brands';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Sku';

	protected $fillable = [
		'name',
	];
}
