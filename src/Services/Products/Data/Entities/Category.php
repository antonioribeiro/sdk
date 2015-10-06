<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Category extends Model
{
	protected $table = 'products_categories';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Sku';

	protected $fillable = [
		'name',
		'parent_id',
	];
}
