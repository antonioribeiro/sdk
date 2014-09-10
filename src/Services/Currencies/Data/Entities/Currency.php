<?php

namespace PragmaRX\Sdk\Services\Currencies\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Currency extends Model {

	protected $fillable = [
		'name',
		'code',
		'symbol',
		'decimals',
		'decimal_point',
		'thousands_separator',
	];

}
