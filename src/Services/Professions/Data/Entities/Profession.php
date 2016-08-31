<?php

namespace PragmaRX\Sdk\Services\Professions\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class Profession extends Model
{
	protected $fillable = [
		'name',
        'code',
        'country_id'
	];

	public function state()
	{
		return $this->belongsTo('PragmaRX\Sdk\Services\States\Data\Entities\State');
	}
}
