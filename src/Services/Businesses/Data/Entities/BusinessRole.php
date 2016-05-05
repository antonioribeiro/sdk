<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class BusinessRole extends Model
{
	protected $table = 'business_roles';

	const POWER_ROOT = 0;
	const POWER_OWNER = 100;
	const POWER_ADMINISTRATOR = 200;
	const POWER_MANAGER = 300;
	const POWER_SUPERVISOR = 400;
	const POWER_TRIAGE = 500;
	const POWER_OPERATOR = 600;

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
