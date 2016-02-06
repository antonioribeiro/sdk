<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Business as BusinessService;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Chat extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository)
	{
		$this->chatRepository = $chatRepository;
	}

	public function index()
	{
		$chats = $this->chatRepository->allChats();

		$currenOperator = $this->chatRepository->getCurrentTalker();

		$currentClientId = BusinessService::getCurrentClient()->id;

		return view('chat.server.index')
			->with('listenChannel', 'chat-channel:PragmaRX\\\\Sdk\\\\Services\\\\Chat\\\\Events\\\\ChatMessageSent')
			->with('currentOperatorId', $currenOperator->id)
			->with('currentOperatorUserId', $currenOperator->user->id)
			->with('currentClientId', $currentClientId)
			->with('chats', $chats);
	}

	public function get($chatId)
	{
		$chat = $this->chatRepository->findById($chatId);

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
