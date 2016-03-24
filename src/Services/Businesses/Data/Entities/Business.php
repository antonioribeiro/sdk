<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Businesses\Data\Presenters\Business as BusinessPresenter;

class Business extends Model
{
	protected $table = 'businesses';

	protected $presenter = BusinessPresenter::class;

	protected $fillable = [
		'name',
	];

	public function clients()
	{
		return $this->hasMany(BusinessClient::class);
	}
}
