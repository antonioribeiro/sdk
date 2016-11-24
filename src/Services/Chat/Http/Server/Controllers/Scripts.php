<?php

namespace PragmaRX\Sdk\Services\Chat\Http\Server\Controllers;

use Gate;
use Auth;
use Flash;
use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScript;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Chat\Commands\CreateScript as CreateScriptCommand;
use PragmaRX\Sdk\Services\Chat\Data\Repositories\Chat as ChatRepository;
use PragmaRX\Sdk\Services\Businesses\Data\Repositories\Businesses as BusinessesRepository;
use PragmaRX\Sdk\Services\Chat\Http\Server\Requests\CreateScript as CreateScriptRequest;
use PragmaRX\Sdk\Services\Chat\Http\Server\Requests\UpdateScript as UpdateScriptRequest;

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
		if (Gate::denies('viewScripts', Auth::user()))
		{
			abort(403);
		}

		$scripts = $this->chatRepository->allScripts();

		return view('scripts.index')
			->with('scripts', $scripts)
			->with('deleteUri', '/chat/server/scripts/delete/')
		;
	}

	public function create()
	{
		if (Gate::denies('create', new ChatScript()))
		{
			abort(403);
		}

		list($services, $clients, $types) = $this->getAllLists();

		return view('scripts.create')
			->with('scriptTypes', $types)
			->with('chatServices', $services)
			->with('businessClients', $clients)
			->with('submitButton', 'Criar script')
			->with('postRoute', 'chat.server.scripts.store')
			->with('cancelRoute', 'chat.server.scripts.index')
		;
	}

	public function store(CreateScriptRequest $request)
	{
		if (Gate::denies('store', new ChatScript()))
		{
			abort(403);
		}

		$this->execute(CreateScriptCommand::class);

		Flash::message(t('paragraphs.script-created'));

		return Redirect::route_no_ajax('chat.server.scripts.index');
	}

	public function edit($scriptId)
	{
		if (Gate::denies('edit', new ChatScript()))
		{
			abort(403);
		}

		list($services, $clients, $types) = $this->getAllLists();

		$script = $this->chatRepository->findScriptById($scriptId);

		return view('scripts.edit')
			->with('scriptTypes', $types)
			->with('chatServices', $services)
			->with('businessClients', $clients)
			->with('postRoute', 'chat.server.scripts.update')
			->with('cancelRoute', 'chat.server.scripts.index')
			->with('script', $script)
		;
	}

	private function getAllLists()
	{
		return [
			$this->chatRepository->allServices()->pluck('name', 'id'),
			$clients = $this->businessesRepository->allClients()->pluck('name', 'id'),
			$types = $this->chatRepository->allScriptTypes()->pluck('description', 'id'),
		];
	}

	public function update(UpdateScriptRequest $request)
	{
		if (Gate::denies('update', new ChatScript()))
		{
			abort(403);
		}

		$this->chatRepository->updateScript($request->all());

		Flash::message(t('paragraphs.script-updated'));

		return Redirect::route_no_ajax('chat.server.scripts.index');
	}

	public function delete($scriptId)
	{
		if (Gate::denies('delete', new ChatScript()))
		{
			abort(403);
		}

		$this->chatRepository->deleteScript($scriptId);

		Flash::message(t('paragraphs.script-deleted'));

		return Redirect::route_no_ajax('chat.server.scripts.index');
	}
}
