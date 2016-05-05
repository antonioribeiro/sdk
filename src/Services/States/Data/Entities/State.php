<?php

namespace PragmaRX\Sdk\Services\States\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class State extends Model {

	protected $fillable = [
		'code',
		'name',
		'country_id',
	];

	public function country()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Countries\Data\Entities\Country');
	}

}
