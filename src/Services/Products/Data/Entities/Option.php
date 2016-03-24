<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Option extends Model
{
	protected $table = 'products_options';

	protected $fillable = [
		'name',
	];
}
