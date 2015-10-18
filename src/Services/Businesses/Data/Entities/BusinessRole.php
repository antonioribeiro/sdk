<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class BusinessRole extends Model
{
	protected $table = 'business_roles';

	protected $fillable = [
		'business_id',
		'name',
		'description',
	];

	public function business()
	{
		return $this->belongsTo(Business::class, 'business_id');
	}
}
