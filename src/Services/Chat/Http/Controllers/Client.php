<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use Redis;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageSent;
use PragmaRX\Sdk\Services\Chat\Commands\CreateChat as CreateChatCommand;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Http\Requests\CreateChat as CreateChatRequest;

class Client extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository)
	{
		$this->chatRepository = $chatRepository;
	}

	public function create()
	{
		return view('chat.client.create');
	}

	public function chat($chat_id)
	{
		$chat = $this->chatRepository->findById($chat_id);

		return view('chat.client.index')
			->with('talkerUsername', $chat->owner->user->first_name)
			->with('talkerEmail', $chat->owner->user->email)
			->with('talkerId', $chat->owner->user->id)
			->with('chatId', $chat_id)
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', $chat->owner->user->present()->avatar)
			->with('talkerAvatar', $chat->owner->user->present()->avatar)
//			->with('listenChannel', 'chat-channel:PragmaRX\\\\Sdk\\\\Services\\\\Chat\\\\Events\\\\ChatMessageSent');
			->with('listenChannel', 'chat-channel:' . $chat_id);
	}

	public function store(CreateChatRequest $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		return redirect('chat/client/'.$chat->id);
	}

	public function sendMessage($chatId, $userId, $message = '')
	{
		$message = $this->chatRepository->createMessage($chatId, $userId, $message);

		if ( ! is_null($message) && ! empty($message))
		{
			$data = [
				'event' => $chatId,

				'data' => $message->toArray()
			];

			Redis::publish('chat-channel', json_encode($data));

			event(new ChatMessageSent($chatId, $userId, $message));
		}
	}
}
