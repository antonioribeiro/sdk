<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Repositories;

use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClient;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientRoom;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientService;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusiness;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientTalker;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatCustomer;
use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;

class Chat extends Repository
{
	private $userRepository;

	protected $model = ChatModel::class;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function create($name, $email)
	{
		$user = $this->userRepository->findByEmailOrCreate($email, ['first_name' => $name], true); // allow empty password

		$business = ChatBusiness::firstOrCreate(['name' => 'Alerj']);

		$client = ChatBusinessClient::firstOrCreate(['chat_business_id' => $business->id, 'name' => 'Alô Alerj']);

		$talker = ChatBusinessClientTalker::firstOrCreate([
			'chat_business_client_id' => $client->id,
			'user_id' => $user->id,
		]);

		$service = ChatService::firstOrCreate(['name' => 'Chat']);

		$clientService = ChatBusinessClientService::firstOrCreate([
			'chat_service_id' => $service->id,
			'chat_business_client_id' => $client->id,
            'description' => 'Chat do Call Center',
		]);

		$room = ChatBusinessClientRoom::firstOrCreate([
			'chat_business_client_service_id' => $clientService->id,
			'name' => 'Sala de Chat'
		]);

		return ChatModel::firstOrCreate([
			'chat_business_client_service_room_id' => $room->id,
			'owner_id' => $talker->id
		]);
	}
}
