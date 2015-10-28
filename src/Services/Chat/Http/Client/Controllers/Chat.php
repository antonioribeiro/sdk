<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Client\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Chat\Commands\CreateChat as CreateChatCommand;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Http\Client\Requests\CreateChat as CreateChatRequest;

class Chat extends BaseController
{
	private $chatRepository;

	/**
	 * @var EventPublisher
	 */
	private $eventPublisher;

	public function __construct(ChatRepository $chatRepository, EventPublisher $eventPublisher)
	{
		$this->chatRepository = $chatRepository;
		$this->eventPublisher = $eventPublisher;
	}

	public function create()
	{
		return view('chat.client.create');
	}

	public function chat($chat_id)
	{
		try {
			$chat = $this->chatRepository->findById($chat_id);
		}
		catch (\Exception $e)
		{
			return redirect()->route('chat.client.create');
		}

		return view('chat.client.index')
			->with('talkerUsername', $chat->owner->user->first_name)
			->with('talkerEmail', $chat->owner->user->email)
			->with('talkerId', $chat->owner->id)
			->with('chatId', $chat_id)
			->with('ownerId', $chat->owner->id)
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', $chat->owner->user->present()->avatar)
			->with('talkerAvatar', $chat->owner->user->present()->avatar)
			->with('listenChannel', 'chat-channel:' . $chat_id);
	}

	public function store(CreateChatRequest $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		$this->eventPublisher->publish('ChatCreated');

		return redirect('chat/client/'.$chat->id);
	}
}
