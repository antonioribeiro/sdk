<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

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

	public function avatar()
	{
		return $this->belongsTo(FileName::class, 'avatar_id');
	}

	public function clientUsers()
	{
		return $this->hasMany(BusinessClientUser::class)->with('user');
	}
}
