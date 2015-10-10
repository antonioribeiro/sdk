<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageSent;
use PragmaRX\Sdk\Services\Chat\Http\Requests\CreateChat;

class Chat extends BaseController
{
	public function create()
	{
		return view('chat.create');
	}

	public function chat(Request $request)
	{
		return view('chat.index')
			->with('chatterUsername', $request->get('username'))
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', env('CHAT_OPERATOR_AVATAR'))
			->with('chatterAvatar', env('CHAT_CHATTER_AVATAR'))
			->with('listenChannel', 'chat-channel:PragmaRX\\\\Sdk\\\\Services\\\\Chat\\\\Events\\\\ChatMessageSent');
	}

	public function store(CreateChat $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		return redirect('chat', ['chat_id' => $chat->id])
				->withInput();
	}

	public function sendMessage($username, $message = '')
	{
		if ( ! is_null($message) && ! empty($message))
		{
			event(new ChatMessageSent($username, $message));
		}
	}
}
