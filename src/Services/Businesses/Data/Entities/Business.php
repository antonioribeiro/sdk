<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Business extends Model
{
	protected $table = 'businesses';

	protected $presenter = 'PragmaRX\Sdk\Services\Businesses\Data\Presenters\Business';

	protected $fillable = [
		'name',
	];

	public function clients()
	{
		return $this->hasMany(BusinessClient::class);
	}
}
