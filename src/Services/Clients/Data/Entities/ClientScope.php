<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class ClientScope extends BaseScope implements ScopeInterface {

	public function apply(Builder $builder)
	{
		parent::apply($builder);

		$builder
			->join('providers_clients', 'users.id', '=', 'providers_clients.client_id');
	}

	public function remove(Builder $builder)
	{
		// no need to remove
	}

}
