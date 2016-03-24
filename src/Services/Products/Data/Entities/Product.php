<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Products\Data\Presenters\Product as ProductPresenter;

class Product extends Model
{
	protected $table = 'products';

	protected $presenter = ProductPresenter::class;

	protected $fillable = [
		'name',
	    'description',
		'brand_id',
		'category_id',
		'unit_id',
	];
}
