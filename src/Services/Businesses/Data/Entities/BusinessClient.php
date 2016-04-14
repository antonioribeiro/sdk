<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientService;
use PragmaRX\Sdk\Services\Businesses\Data\Presenters\BusinessClient as BusinessClientPresenter;

class BusinessClient extends Model
{
	protected $table = 'business_clients';

	protected $fillable = [
		'business_id',
		'name',
	];

	protected $presenter = BusinessClientPresenter::class;

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

    public function chatServices()
    {
        return $this->hasMany(ChatBusinessClientService::class, 'business_client_id')->with('type');
    }
}
