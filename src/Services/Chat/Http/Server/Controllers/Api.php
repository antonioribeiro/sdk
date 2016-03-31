<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Auth;
use Input;
use Markdown;
use Response;
use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageSent;
use PragmaRX\Sdk\Services\Chat\Events\EventPublisher;

class Api extends BaseController
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

	public function allChats()
	{
		return $this->chatRepository->allChats();
	}

	public function getChat($chatId)
	{
		return $this->chatRepository->getChat($chatId);
	}

	public function allChatsForClient($clientId)
	{
		return $this->chatRepository->allChatsForClient($clientId);
	}

    private function response($data)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
        ];

        $response = Response::json($data, 200, $headers);

        if ($callback = Input::get('callback'))
        {
            $response->setCallback($callback);
        }

        return $response;
    }

    public function scripts()
	{
		$scripts = ChatScript::with('type')->get();

		$result = [];

		foreach ($scripts as $script)
		{
			$script->script = $this->markdownToHtml($this->replaceScriptTags($script->script));

			$result[$script->id] = $script;
		}

		return $result;
	}

	private function replaceScriptTags($script)
	{
		$script = str_replace('[operador]', Auth::user()->present()->fullName, $script);

		$script = str_replace('[operator]', Auth::user()->present()->fullName, $script);

		return $script;
	}

	public function sendMessage($chatId, $talkerId, $message = '')
	{
        if (! $message)
        {
            return false;
        }

		$message = $this->chatRepository->createMessage($chatId, $talkerId, $message);

		$chat = $this->chatRepository->findById($chatId);

		if ( ! is_null($message) && ! empty($message))
		{
			$data = [
				'message' => $message->message,
				'fullName' => $chat->owner->user->present()->fullName,
				'avatar' => $chat->owner->user->present()->avatar,
				'owner_id' => $chat->owner->id,
			];

			$this->eventPublisher->publish($chatId, $data);

			event(new ChatMessageSent($chatId, $talkerId, $message));
		}
	}

	public function respond($chatId)
	{
		$response = $this->chatRepository->respond($chatId);

		$this->eventPublisher->publish($chatId . ':ChatResponded');

		return $response;
	}

	public function serverSendMessage(Request $request)
	{
		return $this->sendMessage(
			$request['chatId'],
			$this->chatRepository->getCurrentTalker()->id,
			$request['message']
		);
	}

	public function serverReadMessage(Request $request)
	{
		$read = $this->chatRepository->readMessage($request['chatId'], $request['serial']);

		$this->eventPublisher->publish('ChatRead');

		return response()->json(['success' => true, 'data' => $read]);
	}

	public function terminateChat(Request $request)
	{
		$chat = $this->chatRepository->terminate($request['chatId']);

		$this->eventPublisher->publish('ChatTerminated');
		$this->eventPublisher->publish($request['chatId'] . ':ChatTerminated');

		return response()->json(['success' => true, 'data' => $chat]);
	}

	private function markdownToHtml($script)
	{
		return Markdown::toHtml($script);
	}

    public function ping()
    {
        $this->chatRepository->pingUser();

        return ['success' => true];
    }

    public function operatorsOnlineForClient($clientId)
    {
        return $this->response(
            $this->chatRepository->operatorsOnlineForClient($clientId)->toArray()
        );
    }
}
