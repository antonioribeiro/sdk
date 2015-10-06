<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class OptionValue extends Model
{
	protected $table = 'products_options_values';

	protected $presenter = 'PragmaRX\Sdk\Services\Products\Data\Presenters\OptionValue';

	protected $fillable = [
		'product_option_id',
		'name',
	];
}
