<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Chat extends BaseController
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

	public function get($chatId)
	{
		$chat = ChatModel::find($chatId);

		$result = [];

		foreach($chats as $chat)
		{
			$result[] = [
				'id' => $chat->id,
				'talker' => [
					'fullName' => $chat->owner->user->present()->fullName,
					'avatar' => $chat->owner->user->present()->avatar
				],
				'responder' => $chat->responder ? ['fullName' => $chat->responder->user->present()->fullName] : null,
				'email' => $chat->owner->user->email,
				'isClosed' => is_null($chat->closed_at),
				'service' => strtolower($chat->room->service->type->name),
			];
		}

		return $result;
	}

	public function scripts()
	{
		return ChatScript::with('type')->get();
	}
}
