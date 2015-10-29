<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class BusinessClientUserRole extends Model
{
	protected $table = 'business_client_user_roles';

	protected $fillable = [
		'business_client_user_id',
		'business_role_id',
	];

	public function role()
	{
		return $this->belongsTo(BusinessRole::class, 'business_role_id');
	}

	public function user()
	{
		return $this->belongsTo(BusinessClientUser::class, 'business_client_user_id');
	}
}
