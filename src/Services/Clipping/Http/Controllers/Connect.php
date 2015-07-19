<?php

namespace PragmaRX\Sdk\Services\Clipping\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Clipping\Commands\AcceptInvitationCommand;
use PragmaRX\Sdk\Services\Clipping\Commands\ClippingActionCommand;
use PragmaRX\Sdk\Services\Clipping\Commands\ClippingUserCommand;
use PragmaRX\Sdk\Services\Clipping\Commands\DisconnectUserCommand;
use PragmaRX\Sdk\Services\Clipping\Commands\InviteCommand;
use PragmaRX\Sdk\Services\Clipping\Http\Requests\Invite as InviteRequest;

use Auth;
use Flash;
use Redirect;
use Response;

class Clipping extends BaseController {

	/**
	 * Clipping a user.
	 *
	 * @param $username
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($user_to_connect)
	{
		$input = ['user_to_connect' => $user_to_connect, 'user_id' => Auth::id()];

		$this->execute(ClippingUserCommand::class, $input);

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
		$input = [
			'user' => Auth::user(),
			'connection_id' => $connection_id,
			'action' => $action,
		];

		$this->execute(ClippingActionCommand::class, $input);

		return Redirect::back();
	}

	public function invite(InviteRequest $request)
	{
		$input = [
			'user' => Auth::user(),
			'emails' => $request->get('emails'),
		];

		$this->execute(InviteCommand::class, $input);

		return Redirect::back();
	}

	public function inviteValidate(InviteRequest $request)
	{
		return Response::json(['success' => true]);
	}

	public function acceptInvitation($user_id)
	{
		$input = [
			'user_id' => $user_id,
		];

		$this->execute(AcceptInvitationCommand::class, $input);

		return Redirect::route_no_ajax('notification')
				->with('title', t('titles.invitation-accepted'))
				->with('message', t('paragraphs.invitation-accepted'))
				->withInput();
	}
}
