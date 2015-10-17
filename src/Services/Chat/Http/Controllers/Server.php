<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Server extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository)
	{
		$this->chatRepository = $chatRepository;
	}

	public function all()
	{
		$chats = ChatModel::all();

		$result = [];

		foreach($chats as $chat)
		{
			$result[$chat->id] = [
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
}
