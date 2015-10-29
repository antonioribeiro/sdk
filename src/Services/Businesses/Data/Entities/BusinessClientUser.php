<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Core\Model;

class BusinessClientUser extends Model
{
	protected $table = 'business_client_users';

	protected $fillable = [
		'business_client_id',
		'user_id',
	];

	public function client()
	{
		return $this->belongsTo(BusinessClient::class, 'business_client_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function roles()
	{
		return $this->hasMany(BusinessClientUserRole::class, 'business_client_user_id');
	}
}
