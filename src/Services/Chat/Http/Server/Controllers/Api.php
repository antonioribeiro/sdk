<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Auth;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Api extends BaseController
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

	public function scripts()
	{
		$scripts = ChatScript::with('type')->get();

		foreach ($scripts as $script)
		{
			$script->script = $this->replaceScriptTags($script->script);
		}

		return $scripts;
	}

	private function replaceScriptTags($script)
	{
		$script = str_replace('[operador]', Auth::user()->present()->fullName, $script);

		$script = str_replace('[operator]', Auth::user()->present()->fullName, $script);

		return $script;
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

	public function respond($chatId)
	{
		$response = $this->chatRepository->respond($chatId);

		return $response;
	}
}
