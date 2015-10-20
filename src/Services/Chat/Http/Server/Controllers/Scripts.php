<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Commands\CreateScript as CreateScriptCommand;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;
use PragmaRX\Sdk\Services\Chat\Http\Server\Requests\CreateScript as CreateScriptRequest;

class Scripts extends BaseController
{
	private $chatRepository;

	public function __construct(ChatRepository $chatRepository, BusinessesRepository $businessesRepository)
	{
		$this->chatRepository = $chatRepository;
		$this->businessesRepository = $businessesRepository;
	}

	public function index()
	{
		$scripts = ChatScript::all();

		return view('scripts.index')->with('scripts', $scripts);
	}

	public function create()
	{
		$services = $this->chatRepository->allServices()->lists('name', 'id');
		$clients = $this->businessesRepository->allClients()->lists('name', 'id');

		return view('scripts.create')
				->with('chatServices', $services)
				->with('businessClients', $clients);
	}

	public function store(CreateScriptRequest $request)
	{
		$this->execute(CreateScriptCommand::class);

		Flash::message(t('paragraphs.script-created'));

		return Redirect::route_no_ajax('chats.server.scripts.index');
	}
}
