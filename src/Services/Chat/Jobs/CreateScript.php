<?php

namespace PragmaRX\Sdk\Services\Chat\Jobs;

use PragmaRX\Sdk\Core\Jobs\Job;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class CreateScript extends Job
{
	public $name;

	public $business_client_id;

	public $chat_service_id;

	public $script;

	public $chat_script_type_id;

	public function handle(ChatRepository $chatRepository)
	{
		return $chatRepository->createScript($this->getPublicProperties());;
	}
}
