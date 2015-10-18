<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Repositories;

use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\Business;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
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
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'administrator',
		    'description' => 'Administrador',
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'manager',
		    'description' => 'Gerente',
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'operator',
			'description' => 'Operador',
		]);
	}

	public function createClientForBusiness($business, $name)
	{
		return BusinessClient::firstOrCreate([
			'business_id' => $business->id, 'name' => $name
		]);
	}
}
