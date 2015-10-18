<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Repositories;

use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\Business;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessRole;

class Businesses extends Repository
{
	public function createBusiness($atributes)
	{
		$business = Business::firstOrCreate($atributes);

		$this->createDefaultRolesForBusiness($business);

		return $business;
	}

	private function createDefaultRolesForBusiness($business)
	{
		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'owner',
		    'description' => 'Dono',
		    'power' => 1,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'administrator',
		    'description' => 'Administrador',
			'power' => 2,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'manager',
		    'description' => 'Gerente',
			'power' => 4,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'operator',
			'description' => 'Operador',
			'power' => 8,
		]);
	}

	public function createClientForBusiness($business, $name)
	{
		return BusinessClient::firstOrCreate([
			'business_id' => $business->id, 'name' => $name
		]);
	}

	public function createClientUserRole($client, $role, $user)
	{
		if ( ! is_object($role))
		{
			$role = BusinessRole::where('business_id', $client->business->id)
						->where('name', $role)->first();
		}

		return BusinessClientUserRole::firstOrCreate([
			'business_client_id' => $client->id,
			'business_role_id' => $role->id,
			'user_id' => $user->id,
		]);
	}
}
