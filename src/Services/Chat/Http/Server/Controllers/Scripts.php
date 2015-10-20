<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Flash;
use Redirect;
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
		$scripts = $this->chatRepository->allScripts();

		return view('scripts.index')->with('scripts', $scripts);
	}

	public function create()
	{
		$services = $this->chatRepository->allServices()->lists('name', 'id');
		$clients = $this->businessesRepository->allClients()->lists('name', 'id');
		$types = $this->chatRepository->allScriptTypes()->lists('description', 'id');

		return view('scripts.create')
				->with('scriptTypes', $types)
				->with('chatServices', $services)
				->with('businessClients', $clients);
	}

	public function store(CreateScriptRequest $request)
	{
		$this->execute(CreateScriptCommand::class);

		Flash::message(t('paragraphs.script-created'));

		return Redirect::route_no_ajax('chat.server.scripts.index');
	}
}
