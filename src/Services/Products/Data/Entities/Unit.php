<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Unit extends Model
{
	protected $table = 'products_units';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Sku';

	protected $fillable = [
		'code',
		'name',
	];
}
