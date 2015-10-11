<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use Illuminate\Http\Request;
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
		return view('chat.create');
	}

	public function chat($chat_id)
	{
		$chat = $this->chatRepository->findById($chat_id);

		return view('chat.index')
			->with('chatterUsername', $chat->chat)
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', env('CHAT_OPERATOR_AVATAR'))
			->with('chatterAvatar', env('CHAT_CHATTER_AVATAR'))
			->with('listenChannel', 'chat-channel:PragmaRX\\\\Sdk\\\\Services\\\\Chat\\\\Events\\\\ChatMessageSent');
	}

	public function store(CreateChatRequest $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		return redirect('chat/'.$chat->id);
	}

	public function sendMessage($username, $message = '')
	{
		if ( ! is_null($message) && ! empty($message))
		{
			event(new ChatMessageSent($username, $message));
		}
	}
}
