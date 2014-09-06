<?php

namespace PragmaRX\Sdk\Services\Cities\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class City extends Model {

	protected $fillable = [
		'name',
		'abbreviation',
		'state_id',
	];

}
