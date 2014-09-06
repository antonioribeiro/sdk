<?php

namespace PragmaRX\Sdk\Services\Addresses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Address extends Model {

	protected $fillable = [
		'city_id',
		'street',
		'neighborhood',
		'zip_code',
	];

}
