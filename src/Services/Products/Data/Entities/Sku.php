<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Sku extends Model
{
	protected $table = 'products_skus';

	protected $fillable = [
		'product_id',
	];
}
