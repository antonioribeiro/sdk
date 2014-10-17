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
	public function create()
	{
		return View::make('registration.create');
	}

	/**
	 * @return mixed
	 */
	public function store(RegisterRequest $request)
	{
		$this->execute(RegisterUserCommand::class);

		return Redirect::route('message')
				->with('title', t('titles.welcome'))
				->with('message', t('paragraphs.welcome-message'))
				->with('buttons', [[
									'caption' => t('captions.go-to-login-page'),
				                    'url' => route('login')
				                   ]])
				->withInput();
	}

}
