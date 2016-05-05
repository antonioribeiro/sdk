<?php

namespace PragmaRX\Sdk\Services\Addresses\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Address extends Model {

	protected $fillable = [
		'city_id',
		'street',
		'neighborhood',
		'zip_code',
	];

	public function city()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Cities\Data\Entities\City');
	}

}
