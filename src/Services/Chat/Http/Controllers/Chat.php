<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageSent;

class Chat extends BaseController
{
	public function index(Request $request)
	{
		return view('chat.index')
			->with('operatorUsername', 'Alo Alerj')
			->with('chatterUsername', $request->get('username'))
			->with('operatorAvatar', 'logo-alo-alerj-50px.png')
			->with('chatterAvatar', 'voce.png')
			->with('listenChannel', 'chat-channel:PragmaRX\\Sdk\\Services\\Chat\\Events\\ChatMessageSent');
	}

	public function sendMessage($username, $message)
	{
		event(new ChatMessageSent($username, $message));
	}
}
