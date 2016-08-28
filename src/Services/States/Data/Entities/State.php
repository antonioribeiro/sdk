<?php

namespace PragmaRX\Sdk\Services\States\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Cities\Data\Entities\City;

class State extends Model
{
	protected $fillable = [
		'code',
		'name',
		'country_id',
	];

	public function country()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\Countries\Data\Entities\Country');
	}

    public function cities()
    {
        return $this->hasMany(City::class);
	}
}
