<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

class ClientScope extends BaseScope implements ScopeInterface {

	public function apply(Builder $builder, Model $model)
	{
		parent::apply($builder, $model);

		$builder
			->join('providers_clients', 'users.id', '=', 'providers_clients.client_id');
	}

	public function remove(Builder $builder, Model $model)
	{
		// no need to remove
	}

}
