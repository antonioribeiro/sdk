<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Category extends Model
{
	protected $table = 'products_categories';

	protected $fillable = [
		'name',
		'parent_id',
	];
}
