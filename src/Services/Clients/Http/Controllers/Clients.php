<?php

namespace PragmaRX\Sdk\Services\Clients\Http\Controllers;

use Auth;
use View;
use Flash;
use Redirect;
use Response;
use PragmaRX\Support\Inflectors\Inflector;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Clients\Jobs\AddClientJob;
use PragmaRX\Sdk\Services\Clients\Jobs\DeleteClientJob;
use PragmaRX\Sdk\Services\Clients\Jobs\UpdateClientJob;
use PragmaRX\Sdk\Services\Kinds\Data\Repositories\KindRepository;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;
use PragmaRX\Sdk\Services\Clients\Http\Requests\AddClient as AddClientRequest;
use PragmaRX\Sdk\Services\Clients\Http\Requests\UpdateClient as UpdateClientRequest;

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

		dispatch(new AddClientJob($input));

		Flash::message(
			t(
				'paragraphs.client-created',
				['client' => strtolower(Auth::check() ? Inflector::singular(Auth::user()->present()->clientFieldName) : 'client')]
			)
		);

		return Redirect::back();
	}

	public function validateData(AddClientRequest $request)
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

		$client = dispatch(new UpdateClientJob($input));

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

		dispatch(new DeleteClientJob($input));

		Flash::message(
			t(
				'paragraphs.client-deleted',
				['client' => Auth::check() ? Inflector::singular(Auth::user()->present()->clientFieldName) : 'client']
			)
		);

		return Redirect::route('clients');
	}

}
