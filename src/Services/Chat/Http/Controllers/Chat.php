<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

class Chat extends BaseController
{
	public function index()
	{
		return view('chat.index')
			->with('username', Input::get('username'));
	}

	public function sendMessage($username, $message)
	{
		event(new ChatMessageSent($username, $message));
	}
}
