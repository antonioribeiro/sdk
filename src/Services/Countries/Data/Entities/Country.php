<?php

namespace PragmaRX\Sdk\Services\Countries\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'countries';

    protected $fillable = [
        'code',
        'name',
        'abbreviation',
        'latitude',
        'longitude',
    ];
}
