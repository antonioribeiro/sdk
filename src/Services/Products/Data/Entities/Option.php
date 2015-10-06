<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Option extends Model
{
	protected $table = 'products_options';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\Option';

	protected $fillable = [
		'name',
	];
}
