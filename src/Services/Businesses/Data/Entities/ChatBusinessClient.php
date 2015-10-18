<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class BusinessClient extends Model
{
	protected $table = 'business_clients';

	protected $fillable = [
		'business_id',
		'name',
	];

	public function business()
	{
		return $this->belongsTo(Business::class, 'business_id');
	}
}
