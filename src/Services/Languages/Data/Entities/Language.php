<?php

namespace PragmaRX\Sdk\Services\Languages\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Language extends Model
{
	protected $fillable = [
		'name',
		'abbreviation',
		'state_id',
        'country_id',
        'latitude',
        'longitude',
	];
}
