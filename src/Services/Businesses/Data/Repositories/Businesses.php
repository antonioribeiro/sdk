<?php

namespace PragmaRX\Sdk\Services\Businesses\Data\Repositories;

use Auth;
use Illuminate\Support\Arr;
use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Businesses\Events\UserWasCreated;
use PragmaRX\Sdk\Services\Businesses\Events\UserWasUpdated;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\Business;
use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessRole;
use PragmaRX\Sdk\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUser;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientService;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;

class Businesses extends Repository
{
	protected $model = Business::class;

	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function createBusiness($atributes)
	{
		$atributes = array_only($atributes, $this->getModelFillableAttributes());

		$business = Business::firstOrCreate($atributes);

		$this->createDefaultRolesForBusiness($business);

        Caching::tags(Business::class)->flush();

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
		if ( ! is_object($business))
		{
			$business = $this->findById($business);
		}

		return BusinessClient::firstOrCreate([
			'business_id' => $business->id,
			'name' => $name
		]);
	}

	public function createClientUserRole($clientUser, $businessRoleId)
	{
		if ($businessRoleId instanceof BusinessRole)
		{
			$businessRole = $businessRoleId;
		}
		elseif ( ! $businessRole = BusinessRole::find($businessRoleId))
		{
			$businessRole = BusinessRole::where('name', $businessRoleId)
								->where('business_id', $clientUser->client->business->id)
								->first();
		}

		return BusinessClientUserRole::firstOrCreate(
		[
			'business_client_user_id' => $clientUser->id,
			'business_role_id' => $businessRole->id,
		]);
	}

	public function allClients()
	{
		return BusinessClient::all();
	}

    public function createServiceForClient($businessId, $clientId, $attributes)
    {
        $attributes['business_client_id'] = $clientId;

        $attributes = array_only($attributes, $this->getModelFillableAttributes(new ChatBusinessClientService()));

		return ChatBusinessClientService::firstOrCreate($attributes);
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

    public function deleteService($serviceId)
    {
        $service = $this->findServiceById($serviceId);

        $service->delete();

        return $service;
    }

    public function findUserById($userId)
	{
		return $this->userRepository->findById($userId);
	}

    public function updateService($attributes)
    {
        $client = $this->findServiceById($attributes['id']);

        $attributes = array_only($attributes, $this->getModelFillableAttributes($client));

        $client->fill($attributes);

        $client->save();

        return $client;
    }

    public function updateUser($attributes)
	{
		$user = $this->userRepository->findById($attributes['id']);

		$currentBusinessClientId = $user->present()->businessClient->id;

		$user->fill(Arr::except($attributes, ['business_client_id', 'dispatcher']));

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

	public function allUsers()
	{
		if ($loggedUser = Auth::user())
		{
			if ( ! $loggedUser->is_root)
			{
				if ( ! $role = $loggedUser->businessClientUsers()->first())
				{
					return null;
				}
			}
			else
			{
				return $this->userRepository->allWithBusiness();
			}
		}
		else
		{
			return null;
		}

		$clientUsers = $loggedUser->businessClient->clientUsers;

		$result = [];

		foreach ($clientUsers as $clientUser)
		{
			$result[] = $this->userRepository->makeUserWithBusiness($clientUser->user);
		}

		return $result;
	}

	public function all()
	{
		if ( ! $user = Auth::user())
		{
			return null;
		}

		if (Auth::user()->is_root)
		{
			return Business::cacheTags(Business::class)->remember(60)->get();
		}

		return Auth::user()->businesses;
	}

	public function updateBusiness($attributes)
	{
		$business = $this->findById($attributes['id']);

		$attributes = array_only($attributes, $this->getModelFillableAttributes());

		$business->fill($attributes);

		$business->save();

		return $business;
	}

	public function deleteBusiness($businessId)
	{
		$business = $this->findById($businessId);

		$business->delete();

		return $business;
	}

	public function allClientUsersFor($businessClient)
	{
		return BusinessClientUser::with('user')->where('business_client_id', $businessClient->id)->get();
	}

	public function findClientById($clientId)
	{
        if ($clientId instanceof BusinessClient)
        {
            $clientId = $clientId->id;
        }

		return BusinessClient::cacheTags(BusinessClient::class)->remember(60)->find($clientId);
	}

    public function findServiceById($serviceId)
    {
        return ChatBusinessClientService::find($serviceId);
    }

	public function updateClient($attributes)
	{
		$client = $this->findClientById($attributes['id']);

		$attributes = array_only($attributes, $this->getModelFillableAttributes($client));

		$client->fill($attributes);

		$client->save();

		return $client;
	}

	public function deleteClient($businessId, $clientId)
	{
		$client = $this->findClientById($clientId);

		$client->delete();

		return $client;
	}

	public function getFirst()
	{
		return Business::first();
	}

	public function getFirstClient()
	{
		return BusinessClient::first();
	}

	public function getNewClientModel()
	{
		return new BusinessClient();
	}

	public function addChatLinkToClients($clients)
	{
		return $clients = $clients->each(function ($item, $key)
		{
			$item->chatLink = $item->present()->chatLink;
		});
	}
}
