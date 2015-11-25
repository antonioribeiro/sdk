<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Repositories;

use Auth;
use Baum\Extensions\Eloquent\Collection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatRead;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatMessage;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatCustomer;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScriptType;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;
use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClient;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientTalker;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUser;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientService;
use PragmaRX\Sdk\Services\Businesses\Data\Entities\BusinessClientUserRole;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Chat extends Repository
{
	private $userRepository;

	protected $model = ChatModel::class;

	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	/**
	 * @var Request
	 */
	private $request;

	public function __construct(UserRepository $userRepository, BusinessesRepository $businessesRepository, Request $request)
	{
		$this->userRepository = $userRepository;
		$this->businessesRepository = $businessesRepository;
		$this->request = $request;
	}

	public function create($name, $email, $clientId)
	{
		$user = $this->userRepository->findByEmailOrCreate($email, ['first_name' => $name], true); // allow empty password

		$talker = ChatBusinessClientTalker::firstOrCreate([
			'business_client_id' => $clientId,
			'user_id' => $user->id,
		]);

		$service = ChatService::firstOrCreate(['name' => 'Chat']);

		$clientService = ChatBusinessClientService::firstOrCreate([
			'chat_service_id' => $service->id,
			'business_client_id' => $clientId,
            'description' => 'Chat do Call Center',
		]);

		return ChatModel::firstOrCreate([
			'chat_business_client_service_id' => $clientService->id,
			'owner_id' => $talker->id,
			'owner_ip_address' => $this->request->ip(),
		    'closed_at' => null,
		]);
	}

	public function allChats($open = true)
	{
		$chats = ChatModel::whereNull('closed_at')->get();

		$result = [];

		foreach($chats as $chat)
		{
			$result[$chat->id] = $this->makeChatData($chat);
		}

		return new Collection($result);
	}

	public function createMessage($chatId, $talkerId, $message)
	{
		$chat = $this->findById($chatId);

		$message = ChatMessage::create([
            'chat_id' => $chatId,
            'chat_business_client_talker_id' => $talkerId,
            'talker_ip_address' => $this->request->ip(),
			'message' => $message,
		]);

		$chat->last_message_at = Carbon::now();

		$chat->save();

		return $message;
	}

	public function findTalker($chat, $userId)
	{
		return $this->findOrCreateTalker($chat->service->client, $userId);
	}

	private function makeMessages($all, $chat = null)
	{
		$messages = [];

		foreach($all as $message)
		{
			$messages[$message->id] = [
				'id' => $message->id,
				'message' => $message->message,
			    'talker' => [
				    'id' => $message->talker->id,
				    'fullName' => $message->talker->user->present()->fullName,
			        'avatar' => $this->makeAvatar($message->talker, $chat),
			    ],
				'serial' => str_pad($message->serial, 10, "0", STR_PAD_LEFT),
			    'created_at' => (string) $message->created_at,
			];
		}

		return $messages;
	}

	public function allServices()
	{
		return ChatService::all();
	}

	public function createScript($attributes)
	{
		$script = ChatScript::firstOrCreate(
			[
				'name' => $attributes['name'],
				'business_client_id' => $attributes['business_client_id'],
				'chat_service_id' => $attributes['chat_service_id'],
				'script' => $attributes['script'],
			    'chat_script_type_id' => $attributes['chat_script_type_id'],
			]
		);

		return $script;
	}

	public function allScripts()
	{
		$result = [];

		foreach(ChatScript::all() as $script)
		{
			$result[] = [
				'id' => $script->id,
				'name' => $script->name,
				'script' => $script->script,
				'businessClient' => $script->client->name,
				'service' => $script->service->name,
			];
		}

		return $result;
	}

	public function allScriptTypes()
	{
		return ChatScriptType::all();
	}

	public function respond($chatId)
	{
		$chat = $this->findById($chatId);

		if ( ! $chat)
		{
			return $this->makeResponse(false, 'Chat não localizado');
		}

		if ($chat->responder)
		{
			return $this->makeResponse(false, 'Chat já sendo respondido');
		}

		return $this->makeResponse(
			true,
			'Chat iniciado',
			$this->setChatResponder($chat, Auth::user())
		);
	}

	private function setChatResponder($chat, $user)
	{
		$talker = $this->findOrCreateTalker($chat->service->client, $user);

		$chat->responder_id = $talker->id;

		$chat->opened_at = Carbon::now();

		$chat->save();

		return $chat;
	}

	/**
	 * @return array
	 */
	private function makeResponse($success, $message, $chat = null)
	{
		$response = [
			'success' => $success,
			'message' => $message,
		];

		if ($chat)
		{
			$response['chat'] = $chat;
		}

		return $response;
	}

	private function findOrCreateTalker($client, $userId)
	{
		if ($userId instanceof User)
		{
			$userId = $userId->id;
		}

		return ChatBusinessClientTalker::firstOrCreate([
			'business_client_id' => $client->id,
			'user_id' => $userId,
		]);
	}

	public function getCurrentTalker()
	{
		$client = BusinessClient::first();

		return $this->findOrCreateTalker($client, Auth::user());
	}

	public function readMessage($chatId, $serial)
	{
		$talker = $this->findTalker($chat = $this->findById($chatId), Auth::user()->id);

		$read = $this->findChatLastReadMessage($talker, $chat);

		if ( ! $read)
		{
			$read = new ChatRead();
			$read->chat_business_client_talker_id = $talker->id;
			$read->chat_id = $chat->id;
		}

		if ($read->last_read_message_serial < $serial)
		{
			$read->last_read_message_serial = $serial;

			$read->save();
		}

		return $read;
	}

	private function getChatLastReadSerial($chat, $userId)
	{
		$read = $this->findChatLastReadMessage(
			$this->findTalker($chat, $userId),
			$chat
		);

		return $read ? $read->last_read_message_serial : 0;
	}

	private function findChatLastReadMessage($talker, $chat)
	{
		return ChatRead::where('chat_business_client_talker_id', $talker->id)
						->where('chat_id', $chat->id)
						->first();
	}

	private function getLastMessageSerial($messages)
	{
		$serial = 0;

		foreach ($messages as $message)
		{
			$serial = max($message['serial'], $serial);
		}

		return $serial;
	}

	public function terminate($chatId)
	{
		$chat = $this->findById($chatId);

		$chat->closed_at = Carbon::now();

		$chat->save();

		return $chat;
	}

	public function getChat($chatId)
	{
		$chat = $this->findById($chatId);

		return $this->makeChatData($chat);
	}

	private function makeChatData($chat)
	{
		$user = Auth::user() ?: $chat->owner->user;

		$messages = $this->makeMessages(
			$chat->messages()
				->with('talker.user')
				->orderBy('serial', 'desc')
				->get(),
			$chat
		);

		$data = [];

		$lastMessageSerial = $this->getLastMessageSerial($messages);

		$data['id'] = $chat->id;

		$data['talker'] = [
			'fullName' => $chat->owner->user->present()->fullName,
			'avatar' => $chat->owner->user->present()->avatar
		];

		$data['responder'] = $chat->responder_id
								?   [
										'fullName' => $chat->responder->user->present()->fullName,
								        'id' => $chat->responder->user->id,
									]
								: null;
		$data['responder_id'] = $chat->responder_id;
		$data['email'] = $chat->owner->user->email;
		$data['isClosed'] = is_null($chat->closed_at);
		$data['service'] = strtolower($chat->service->type->name);
		$data['messages'] = $this->makeMessages($chat->messages()->with('talker.user')->get(), $chat);
		$data['opened_at'] = (string) $chat->opened_at;
		$data['last_message_at'] = (string) $chat->last_message_at;
		$data['closed_at'] = (string) $chat->closed_at;
		$data['created_at'] = (string) $chat->created_at;
		$data['updated_at'] = (string) $chat->updated_at;
		$data['last_read_message_serial'] = $this->getChatLastReadSerial($chat, $user->id);
		$data['last_message_serial'] = $lastMessageSerial;

		return $data;
	}

	private function makeAvatar($talker, $chat)
	{
		$role = $this->findRoleByTalker($talker);

		if ($role && $talker->client->avatar)
		{
			$avatar = $talker->client->avatar->file->getUrl();
		}
		else
		{
			$avatar = $talker->user->present()->avatar;
		}

		return $avatar;
	}

	/**
	 * @param $id
	 * @return \PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript|null
	 */
	public function findScriptById($id)
	{
		return ChatScript::find($id);
	}

	public function updateScript($attributes)
	{
		$script = $this->findScriptById($attributes['id']);

		$attributes = array_only($attributes, $this->getModelFillableAttributes($script));

		$script->fill($attributes);

		$script->save();
	}

	public function deleteScript($scriptId)
	{
		$script = $this->findScriptById($scriptId);

		$script->delete();

		return $script;
	}

	/**
	 * @param $talker
	 * @return mixed
	 */
	private function findRoleByTalker($talker)
	{
		if ($clientUser = $this->findClientUserByTalker($talker))
		{
			return BusinessClientUserRole::where('business_client_user_id', $clientUser->id)->first();
		}

		return null;
	}

	private function findClientUserByTalker($talker)
	{
		return BusinessClientUser::where('user_id', $talker->user->id)->first();
	}

	public function allChatsForClient($clientId)
	{
		$chats = ChatModel::select('chats.*')
					->join('chat_business_client_services', 'chats.chat_business_client_service_id', '=', 'chat_business_client_services.id')
					->whereNull('closed_at')
					->where('chat_business_client_services.business_client_id', $clientId)
					->get();

		$result = [];

		foreach($chats as $chat)
		{
			$result[$chat->id] = $this->makeChatData($chat);
		}

		return $result;
	}
}
