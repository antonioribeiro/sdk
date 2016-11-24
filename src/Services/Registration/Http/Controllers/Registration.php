<?php

namespace PragmaRX\Sdk\Services\Registration\Http\Controllers;

use Config;
use View;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Registration\Jobs\RegisterUser as RegisterUserJob;
use PragmaRX\Sdk\Services\Registration\Http\Requests\Register as RegisterRequest;

class Registration extends BaseController
{
	/**
	 * @return mixed
	 */
	public function create($invite_code = null)
	{
		$invite_only = config('env.INVITE_ONLY') &&
						$invite_code !== config('env.INVITE_ONLY_FREEPASS');

		return View::make('registration.create', compact('invite_only'));
	}

	/**
	 * @return mixed
	 */
	public function store(RegisterRequest $request)
	{
		dispatch(new RegisterUserJob($this->getRequestInput($request)));

		return Redirect::route_no_ajax('notification')
				->with('title', t('titles.welcome'))
				->with('message', t('paragraphs.welcome-message'))
				->with('buttons', [[
									'caption' => t('captions.go-to-login-page'),
				                    'url' => route('auth.login')
				                   ]])
				->withInput();
	}

	private function getRequestInput($request)
	{
		$input = $request->all();

		if (Config::get('app.register.username') === false)
		{
			$input['username'] = null;
		}

		if (Config::get('app.register.last_name') === false)
		{
			$input['last_name'] = null;
		}

		return $input;
	}
}
