<?php

namespace PragmaRX\Sdk\Services\Registration\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Registration\Commands\RegisterUserCommand;
use PragmaRX\Sdk\Services\Registration\Http\Requests\Register as RegisterRequest;
use View;
use Redirect;

class Registration extends BaseController {

	/**
	 * @return mixed
	 */
	public function create($invite_code = null)
	{
		$invite_only = env('INVITE.ONLY') &&
						$invite_code !== env('INVITE.ONLY.FREEPASS');

		return View::make('registration.create', compact('invite_only'));
	}

	/**
	 * @return mixed
	 */
	public function store(RegisterRequest $request)
	{
		$this->execute(RegisterUserCommand::class);

		return Redirect::route_no_ajax('notification')
				->with('title', t('titles.welcome'))
				->with('message', t('paragraphs.welcome-message'))
				->with('buttons', [[
									'caption' => t('captions.go-to-login-page'),
				                    'url' => route('login')
				                   ]])
				->withInput();
	}

}
