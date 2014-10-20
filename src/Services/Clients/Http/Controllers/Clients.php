<?php

namespace PragmaRX\Sdk\Services\Clients\Http\Controllers;

use ConsultorioDigital\Services\Users\Data\Repositories\UserRepository;
use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use PragmaRX\Sdk\Services\Clients\Commands\AddClientCommand;
use PragmaRX\Sdk\Services\Clients\Commands\DeleteClientCommand;
use PragmaRX\Sdk\Services\Clients\Commands\UpdateClientCommand;
use PragmaRX\Sdk\Services\Clients\Data\Repositories\ClientRepository;
use PragmaRX\Sdk\Services\Clients\Http\Requests\AddClient as AddClientRequest;
use PragmaRX\Sdk\Services\Clients\Http\Requests\UpdateClient as UpdateClientRequest;
use PragmaRX\Sdk\Services\Kinds\Data\Repositories\KindRepository;
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
		$input = array_merge(['user' => Auth::user()], $request->all());

		$this->execute(AddClientCommand::class, $input);

		Flash::message(t('paragraphs.client-created'));

		return Redirect::back();
	}

	public function validate(AddClientRequest $request)
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
		];

		$client = $this->execute(UpdateClientCommand::class, $input);

		Flash::message(t('paragraphs.client-updated'));

		return Redirect::route('clients.edit', ['id' => $client->id]);
	}

	public function delete(UpdateClientRequest $request, $id)
	{
		$input = [
			'user' => Auth::user(),
			'id' => $id,
		];

		$this->execute(DeleteClientCommand::class, $input);

		Flash::message(t('paragraphs.client-deleted'));

		return Redirect::route('clients');
	}

}
