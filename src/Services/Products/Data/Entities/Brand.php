<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Brand extends Model
{
	protected $table = 'products_brands';

	protected $fillable = [
		'name',
	];
}
