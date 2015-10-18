<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use App\Services\Users\Data\Entities\User;

class BusinessClientUserRole extends Model
{
	protected $table = 'business_client_user_role';

	protected $fillable = [
		'business_client_id',
		'business_role_id',
		'name',
	];

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}

	public function role()
	{
		return $this->belongsTo(BusinessRole::class, 'business_role_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
