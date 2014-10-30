<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class BaseScope implements ScopeInterface {

	public function apply(Builder $builder)
	{
		$tableName = $builder->getModel()->getTable();

		$builder->select([
			"{$tableName}.*",
			'providers_clients.notes',
			'providers_clients.color',
			'providers_clients.birthdate',
		]);
	}

	/**
	 * Remove the scope from the given Eloquent query builder.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $builder
	 * @return void
	 */
	public function remove(Builder $builder)
	{
		// TODO: Implement remove() method.
	}

}
