<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Client\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses;
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

    /**
     * @var Businesses
     */
    private $businessesRepository;

    public function __construct(ChatRepository $chatRepository, EventPublisher $eventPublisher, Businesses $businessesRepository)
	{
		$this->chatRepository = $chatRepository;
		$this->eventPublisher = $eventPublisher;
        $this->businessesRepository = $businessesRepository;
    }

	public function create($clientId, $layout = 'master')
	{
        $client = $this->businessesRepository->findClientById($clientId);

        if ( ! $client) {
            return redirect()->route('home');
        }

		return view('chat.client.create')
            ->with('clientId', $clientId)
            ->with('layout', $layout)
            ->with('businessClientName', $client->name);
	}

	public function chat($chat_id)
	{
		try {
			$chat = $this->chatRepository->findById($chat_id);
		}
		catch (\Exception $e)
		{
			return $this->redirectToHome();
		}

		if ($chat->closed_at)
		{
			return $this->redirectToHome();
		}

		return view('chat.client.index')
            ->with('businessClientName', $chat->service->client->name)
            ->with('talkerUsername', $chat->owner->user->username)
			->with('talkerFirstName', $chat->owner->user->first_name)
            ->with('talkerName', $chat->owner->user->present()->fullName)
			->with('talkerEmail', $chat->owner->user->email)
			->with('talkerId', $chat->owner->id)
			->with('chatId', $chat_id)
			->with('ownerId', $chat->owner->id)
			->with('operatorUsername', env('CHAT_OPERATOR_USERNAME'))
			->with('operatorAvatar', $chat->owner->user->present()->avatar)
			->with('talkerAvatar', $chat->owner->user->present()->avatar)
			->with('listenChannel', 'chat-channel:' . $chat_id)
            ->with('layout', $chat->layout);
	}

	public function store(CreateChatRequest $request)
	{
		$chat = $this->execute(CreateChatCommand::class, $request->all());

		$this->eventPublisher->publish('ChatCreated');

		return redirect('chat/client/'.$chat->id);
	}

	public function terminated($chatId)
	{
        try {
            $chat = $this->chatRepository->findById($chatId);
        }
        catch (\Exception $e)
        {
            return $this->redirectToHome();
        }

		return view('chat.client.terminated')->with('layout', $chat->layout);
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	private function redirectToHome()
	{
		return redirect()->route('chat.client.create');
	}
}
