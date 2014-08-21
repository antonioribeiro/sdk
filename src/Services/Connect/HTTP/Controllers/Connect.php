<?php

namespace PragmaRX\SDK\Services\Connect\HTTP\Controllers;

use Auth;
use Flash;
use PragmaRX\SDK\Core\Redirect;
use PragmaRX\SDK\Core\Controller as BaseController;
use PragmaRX\SDK\Services\Connect\Commands\ConnectUserCommand;
use PragmaRX\SDK\Services\Connect\Commands\DisconnectUserCommand;

class Connect extends BaseController {

	/**
	 * Create a Connect instance.
	 *
	 */
	public function __construct()
	{
		$this->beforeFilter('auth');
	}

	/**
	 * Connect a user.
	 *
	 * @param $username
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($user_to_connect)
	{
		$input = ['user_to_connect' => $user_to_connect, 'user_id' => Auth::id()];

		$this->execute(ConnectUserCommand::class, $input);

		Flash::message('You are now connected to this user.');

		return Redirect::route('profile', ['username' => $user_to_connect]);
	}

	/**
	 * Disconnect a user.
	 *
	 * @param $user_to_disconnect
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($user_to_disconnect)
	{
		$input = [
			'user_to_disconnect' => $user_to_disconnect,
			'user_id' => Auth::id()
		];

		$this->execute(DisconnectUserCommand::class, $input);

		Flash::message('You are not connected to this user anymore.');

		return Redirect::route('profile', ['username' => $user_to_disconnect]);
	}
}
