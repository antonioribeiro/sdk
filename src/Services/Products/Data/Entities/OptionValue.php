<?php

namespace PragmaRX\Sdk\Services\Products\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class OptionValue extends Model
{
	protected $table = 'products_options_values';

	protected $fillable = [
		'product_option_id',
		'name',
	];
}
