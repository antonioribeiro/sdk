<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Repositories;

use Auth;
use Illuminate\Support\Arr;
use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\Business;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUser;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessRole;
use PragmaRX\Sdk\Services\Businesses\Events\UserWasCreated;
use PragmaRX\Sdk\Services\Businesses\Events\UserWasUpdated;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;

class Businesses extends Repository
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

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
		    'power' => BusinessRole::POWER_OWNER,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'administrator',
		    'description' => 'Administrador',
			'power' => BusinessRole::POWER_ADMINISTRATOR,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'manager',
		    'description' => 'Gerente',
			'power' => BusinessRole::POWER_MANAGER,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'supervisor',
			'description' => 'Supervisor',
			'power' => BusinessRole::POWER_SUPERVISOR,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'triage',
			'description' => 'Triagem',
			'power' => BusinessRole::POWER_TRIAGE,
		]);

		BusinessRole::firstOrCreate([
			'business_id' => $business->id,
			'name' => 'operator',
			'description' => 'Operador',
			'power' => BusinessRole::POWER_OPERATOR,
		]);
	}

	public function createClientForBusiness($business, $name)
	{
		return BusinessClient::firstOrCreate([
			'business_id' => $business->id, 'name' => $name
		]);
	}

	public function createClientUserRole($clientUser, $businessRoleId)
	{
		return BusinessClientUserRole::firstOrCreate([
			'business_client_user_id' => $clientUser->id,
			'business_role_id' => $businessRoleId,
		]);
	}

	public function allClients()
	{
		return BusinessClient::all();
	}

	public function createUser($attributes)
	{
		$user = $this->userRepository->findByEmailOrCreate(
			$attributes['email'],
			[
				'first_name' => $attributes['first_name'],
				'last_name' => $attributes['last_name'],
			],
			true
		);

		$client = BusinessClient::find($attributes['business_client_id']);

		$clientUser = BusinessClientUser::firstOrCreate([
			'business_client_id' => $client->id,
			'user_id' => $user->id,
		]);

		$this->createClientUserRole($clientUser, $attributes['business_role_id']);

		event(new UserWasCreated($user));

		return $user;
	}

	public function findUserById($userId)
	{
		return $this->userRepository->findById($userId);
	}

	public function updateUser($attributes)
	{
		$user = $this->userRepository->findById($attributes['id']);

		$currentBusinessClientId = $user->present()->businessClient->id;

		$user->setRawAttributes(Arr::except($attributes, ['business_client_id', 'dispatcher']));

		$user->save();

		$clientUser = BusinessClientUser::firstOrCreate([
			'business_client_id' => $currentBusinessClientId,
			'user_id' => $user->id,]);

		if ($clientUser->business_client_id !== $attributes['business_client_id'])
		{
			$clientUser->business_client_id = $attributes['business_client_id'];
			$clientUser->save();
		}

		event(new UserWasUpdated($user));

		return $user;
	}

	public function allowedRoles()
	{
		$user = Auth::user();

		if ($user->is_root)
		{
			return BusinessRole::all();
		}

		$business = $user->businessClient->business;
		$userRole = $user->businessRole;

		return BusinessRole::where('power', '>=', $userRole->power)
				->where('business_id', $business->id)
				->get()
		;
	}
}
