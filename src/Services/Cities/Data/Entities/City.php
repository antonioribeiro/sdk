<?php

namespace PragmaRX\Sdk\Services\Cities\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class City extends Model {

	protected $fillable = [
		'name',
		'abbreviation',
		'state_id',
	];

	public function state()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\States\Data\Entities\State');
	}

}
