<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

class Provider extends Client {

	protected $table = 'users';

	protected $presenter = 'PragmaRX\Sdk\Services\Clients\Data\Entities\ProviderPresenter';

	protected static function boot()
	{
		static::addGlobalScope(new ProviderScope);

		parent::boot();
	}

	public function scopeHavingAsClient($query, $client)
	{
		if ($client instanceof User)
		{
			$client = $client->id;
		}

		return $query->where('client_id', $client);
	}

}
