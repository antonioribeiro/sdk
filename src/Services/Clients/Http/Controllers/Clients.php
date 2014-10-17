<?php

namespace PragmaRX\Sdk\Services\Clients\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use PragmaRX\Sdk\Services\Clients\Commands\AddClientCommand;
use PragmaRX\Sdk\Services\Clients\Http\Requests\AddClient as AddClientRequest;
use Redirect;
use View;
use Response;

class Clients extends BaseController {

	public function index()
	{
		$clients = Auth::user()->clientsByName;

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

}
