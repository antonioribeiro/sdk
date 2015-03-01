<?php

namespace PragmaRX\Sdk\Services\Clients\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Clients\Commands\AddClientCommand;
use PragmaRX\Sdk\Services\Clients\Commands\DeleteClientCommand;
use PragmaRX\Sdk\Services\Clients\Commands\UpdateClientCommand;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;
use PragmaRX\Sdk\Services\Clients\Http\Requests\AddClient as AddClientRequest;
use PragmaRX\Sdk\Services\Clients\Http\Requests\UpdateClient as UpdateClientRequest;
use PragmaRX\Sdk\Services\Kinds\Data\Repositories\KindRepository;
use PragmaRX\Support\Inflectors\Inflector;

use Auth;
use Flash;
use Redirect;
use View;
use Response;

class Clients extends BaseController {

	public function index(ClientRepository $clientRepository)
	{
		$clients = $clientRepository->clientsFromProvider(Auth::user());

		return View::make('clients.index')->with('clients', $clients);
	}

	public function post(AddClientRequest $request)
	{
		$input = [
			'user' => Auth::user(),
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name')  ?: null,
			'email' => $request->get('email')  ?: null,
			'birthdate' => $request->get('birthdate') ?: null,
		];

		$this->execute(AddClientCommand::class, $input);

		Flash::message(
			t(
				'paragraphs.client-created',
				['client' => strtolower(Auth::check() ? Inflector::singular(Auth::user()->present()->clientFieldName) : 'client')]
			)
		);

		return Redirect::back();
	}

	public function validateAdd(AddClientRequest $request)
	{
		return Response::json(['success' => true]);
	}

	public function edit(
		UpdateClientRequest $request,
		ClientRepository $clientRepository,
		KindRepository $kindRespository,
		$id
	)
	{
		$client = $clientRepository->findClientById(Auth::user()->id, $id);

		return View::make('clients.edit')
				->with('client', $client)
				->with('kinds', $kindRespository->allForSelect());
	}

	public function update(UpdateClientRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'client_id' => $id,
			'id' => $request->get('id'),
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'email' => $request->get('email'),
			'notes' => $request->get('notes'),
			'color' => $request->get('color'),
			'birthdate' => $request->get('birthdate') ?: null,
		];

		$client = $this->execute(UpdateClientCommand::class, $input);

		Flash::message(
			t(
				'paragraphs.client-updated',
				['client' => Auth::check() ? Inflector::singular(Auth::user()->present()->clientFieldName) : 'client']
			)
		);

		return Redirect::route('clients.edit', ['id' => $client->id]);
	}

	public function delete(UpdateClientRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'id' => $id,
		];

		$this->execute(DeleteClientCommand::class, $input);

		Flash::message(
			t(
				'paragraphs.client-deleted',
				['client' => Auth::check() ? Inflector::singular(Auth::user()->present()->clientFieldName) : 'client']
			)
		);

		return Redirect::route('clients');
	}

}
