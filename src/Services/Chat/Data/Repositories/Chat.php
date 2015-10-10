<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Repositories;

use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusiness;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatCustomer;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatRoom;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;

class Chat
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function create($name, $email)
	{
		$user = $this->userRepository->findByEmailOrCreate($email, ['first_name' => $name], true); // allow empty password

		$business = ChatBusiness::firstOrCreate(['name' => 'Alerj']);

		$customer = ChatCustomer::firstOrCreate(['chat_business_id' => $business->id, 'name' => 'Alô Alerj']);

		$customer = ChatRoom::firstOrCreate(['chat_customer_id' => $customer->id, 'name' => 'Call Center']);

		return ChatModel::firstOrCreate(['chat_room_id' => $customer->id, 'owner_id' => $user->id]);
	}

	public function find($id)
	{
		return Chat::find($id);
	}
}
