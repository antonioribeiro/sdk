<?php

namespace PragmaRX\Sdk\Services\Chat\Commands;

use PragmaRX\Sdk\Services\Bus\Commands\SelfHandlingCommand;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class CreateScript extends SelfHandlingCommand
{
	public $name;

	public $business_client_id;

	public $chat_service_id;

	public $script;

	public $chat_script_type_id;

	public function handle(ChatRepository $chatRepository)
	{
		$result = $chatRepository->createScript($this->getPublicProperties());

		return $result;
	}
}
