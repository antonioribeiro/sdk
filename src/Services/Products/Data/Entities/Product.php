<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Product extends Model
{
	protected $table = 'products';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Product';

	protected $fillable = [
		'name',
	    'description',
		'brand_id',
		'category_id',
		'unit_id',
	];
}
