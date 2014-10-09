<?php

namespace PragmaRX\Sdk\Services\Clients\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use PragmaRX\Sdk\Services\Clients\Http\Requests\AddClient as AddClientRequest;
use Redirect;
use View;
use Response;

class Clients extends BaseController {

	public function index()
	{
		$clients = Auth::user()->clients;

		return View::make('clients.index')->with('clients', $clients);
	}

	public function post()
	{
		dd('request');
		$input = array_merge(['user' => Auth::user()], $request->all());

		$this->execute(AddClientCommand::class, $input);

		Flash::message(t('paragraphs.disconnected-from-user'));

		return Redirect::route('profile', ['username' => $user_to_disconnect]);
	}

	public function validate(AddClientRequest $request)
	{
		return Response::json(['success' => true]);
	}

}
