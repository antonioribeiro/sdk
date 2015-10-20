<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Repositories;

use PragmaRX\Sdk\Core\Data\Repository;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScriptType;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatService;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatMessage;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatCustomer;
use PragmaRX\Sdk\Services\Users\Data\Contracts\UserRepository;
use PragmaRX\Sdk\Services\Chat\Data\Entities\Chat as ChatModel;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientTalker;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatBusinessClientService;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;

class Chat extends Repository
{
	private $userRepository;

	protected $model = ChatModel::class;

	/**
	 * @var BusinessesRepository
	 */
	private $businessesRepository;

	public function __construct(UserRepository $userRepository, BusinessesRepository $businessesRepository)
	{
		$this->userRepository = $userRepository;
		$this->businessesRepository = $businessesRepository;
	}

	public function create($name, $email)
	{
		$user = $this->userRepository->findByEmailOrCreate($email, ['first_name' => $name], true); // allow empty password

		$business = $this->businessesRepository->createBusiness(['name' => 'Alerj']);

		$client = $this->businessesRepository->createClientForBusiness($business, 'Alô Alerj');

		$talker = ChatBusinessClientTalker::firstOrCreate([
			'business_client_id' => $client->id,
			'user_id' => $user->id,
		]);

		$service = ChatService::firstOrCreate(['name' => 'Chat']);

		$clientService = ChatBusinessClientService::firstOrCreate([
			'chat_service_id' => $service->id,
			'business_client_id' => $client->id,
            'description' => 'Chat do Call Center',
		]);

		return ChatModel::firstOrCreate([
			'chat_business_client_service_id' => $clientService->id,
			'owner_id' => $talker->id
		]);
	}

	public function all()
	{
		$chats = ChatModel::all();

		$result = [];

		foreach($chats as $chat)
		{
			$result[$chat->id] = [
				'id' => $chat->id,
				'talker' => [
					'fullName' => $chat->owner->user->present()->fullName,
					'avatar' => $chat->owner->user->present()->avatar
				],
				'responder' => $chat->responder ? ['fullName' => $chat->responder->user->present()->fullName] : null,
				'email' => $chat->owner->user->email,
				'isClosed' => is_null($chat->closed_at),
				'service' => strtolower($chat->service->type->name),
			    'messages' => $this->makeMessages($chat->messages()->with('talker.user')->get()),
			];
		}

		return $result;
	}

	public function createMessage($chatId, $userId, $message)
	{
		$chat = ChatModel::find($chatId);

		$talker = $this->findTalker($chat, $userId);

		return ChatMessage::create([
            'chat_id' => $chatId,
			'chat_business_client_talker_id' => $talker->id,
			'message' => $message,
		]);
	}

	private function findTalker($chat, $userId)
	{
		return ChatBusinessClientTalker::where('user_id', $userId)
					->where('business_client_id', $chat->service->business_client_id)
					->first();
	}

	private function makeMessages($get)
	{
		$messages = [];

		foreach($get as $message)
		{
			$messages[] = [
				'message' => $message->message,
			    'talker' => [
				    'id' => $message->talker->id,
				    'fullName' => $message->talker->user->present()->fullName,
			        'avatar' => $message->talker->user->present()->avatar,
			    ]
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
}
