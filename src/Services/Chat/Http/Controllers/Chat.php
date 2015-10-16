<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageSent;
use PragmaRX\Sdk\Services\Chat\Commands\CreateChat as CreateChatCommand;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Http\Requests\CreateChat as CreateChatRequest;

class Chat extends BaseController
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
			->with('chatterUsername', $chat->owner->user->first_name)
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', $chat->owner->user->present()->avatar)
			->with('chatterAvatar', $chat->owner->user->present()->avatar)
			->with('listenChannel', 'chat-channel:PragmaRX\\\\Sdk\\\\Services\\\\Chat\\\\Events\\\\ChatMessageSent');
	}

	public function store(CreateChatRequest $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		return redirect('chat/client/'.$chat->id);
	}

	public function sendMessage($username, $message = '')
	{
		if ( ! is_null($message) && ! empty($message))
		{
			event(new ChatMessageSent($username, $message));
		}
	}
}
