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
			->with('username', $request->get('username'));
	}

	public function sendMessage($username, $message)
	{
		event(new ChatMessageSent($username, $message));
	}
}
