<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Api extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository)
	{
		$this->chatRepository = $chatRepository;
	}

	public function all()
	{
		return $this->chatRepository->all();
	}

	public function scripts()
	{
		return ChatScript::with('type')->get();
	}
}
