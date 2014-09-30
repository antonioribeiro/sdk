<?php

namespace PragmaRX\Sdk\Services\Connect\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Connect\Commands\ConnectActionCommand;
use PragmaRX\Sdk\Services\Connect\Commands\ConnectUserCommand;
use PragmaRX\Sdk\Services\Connect\Commands\DisconnectUserCommand;

use Auth;
use Flash;
use Redirect;

class Connect extends BaseController {

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

		Flash::message(t('paragraphs.connection-request-sent'));

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

		Flash::message(t('paragraphs.disconnected-from-user'));

		return Redirect::route('profile', ['username' => $user_to_disconnect]);
	}

	public function takeAction($connection_id, $action)
	{
		dd(Auth::user()->pendingConnectionTo($connection_id)->pivot);

		$input = [
			'user' => Auth::user(),
			'connection_id' => $connection_id,
			'action' => $action,
		];

		$this->execute(ConnectActionCommand::class, $input);

		Flash::message(t('paragraphs.disconnected-from-user'));

		return Redirect::back();
	}

}
