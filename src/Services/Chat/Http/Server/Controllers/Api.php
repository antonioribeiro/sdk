<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Auth;
use Input;
use Markdown;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasRead;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasResponded;
use PragmaRX\Sdk\Services\Chat\Events\ChatWasTerminated;
use Response;
use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Chat\Events\ChatMessageWasSent;
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

    public function clientSendMessage(Request $request)
    {
        return $this->sendMessage(
            $request->get('message'),
            $request->get('chatId'),
            $request->get('talkerId')
        );
    }

    public function sendMessage($message, $chatId, $talkerId)
	{
        if (! $message)
        {
            return $this->error();
        }

		$message = $this->chatRepository->createMessage($chatId, $talkerId, $message);

		$chat = $this->chatRepository->findById($chatId);

		if ( ! is_null($message) && ! empty($message))
		{
			$data = [
                'chat_id' => $chatId,
				'message' => $message->message,
				'fullName' => $chat->owner->user->present()->fullName,
				'avatar' => $chat->owner->user->present()->avatar,
				'owner_id' => $chat->owner->id,
                'talker_id' => $talkerId,
			];

			

			event(new ChatMessageWasSent($data));
		}
	}

	public function respond($chatId)
	{
		$response = $this->chatRepository->respond($chatId);

		event(new ChatWasResponded($response));

		return $response;
	}

	public function serverSendMessage(Request $request)
	{
		return $this->sendMessage(
            $request['message'],
			$request['chatId'],
			$this->chatRepository->getCurrentTalker()->id
		);
	}

	public function serverReadMessage(Request $request)
	{
		$read = $this->chatRepository->readMessage($request['chatId'], $request['serial']);

        event(new ChatWasRead($read));

		return response()->json(['success' => true, 'data' => $read]);
	}

	public function terminateChat(Request $request)
	{
		$chat = $this->chatRepository->terminate($request['chatId']);

        event(new ChatWasTerminated($chat));

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
