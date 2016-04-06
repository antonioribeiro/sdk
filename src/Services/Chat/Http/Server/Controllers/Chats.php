<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Business as BusinessService;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;

class Chats extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository)
	{
		$this->chatRepository = $chatRepository;
	}

	public function index()
	{
		$chats = $this->chatRepository->allChats(false);

		return view('chats.index')
			    ->with('chats', $chats);
	}

    public function show($chatId)
    {
        $chat = $this->chatRepository->getChat($chatId);

//        dd($chat);

        return view('chats.show')
                ->with('chat', $chat);
    }
}
