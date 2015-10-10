<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Repositories;

use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusiness;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatCustomer;

class Chat
{
	public function create($name, $email)
	{
		$business = ChatBusiness::firstOrCreate(['name' => 'Alerj']);

		$customer = ChatCustomer::firstOrCreate(['chat_business_id' => $business->id, 'name' => 'Alô Alerj']);

		return ChatModel::firstOrCreate(['chat_customer_id' => $customer->id]);
	}
}
