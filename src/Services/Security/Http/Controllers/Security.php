<?php

namespace PragmaRX\Sdk\Services\Security\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Security\Commands\RequestToggleEmailCommand;
use PragmaRX\Sdk\Services\Security\Commands\ToggleEmailCommand;
use PragmaRX\Sdk\Services\Security\Commands\ToggleGoogleCodeCommand;
use PragmaRX\Sdk\Services\Security\Http\Requests\GoogleCodeRequest;

use View;
use Auth;
use Flash;
use Redirect;

class Security extends BaseController {

	public function edit()
	{
		return View::make('security.edit')->with('user', Auth::user());
	}

	public function google(GoogleCodeRequest $request)
	{
		$user = $this->execute(ToggleGoogleCodeCommand::class, ['user' => Auth::user()]);

		if ($user->two_factor_google_enabled)
		{
			Flash::message(t('paragraphs.two-factor-google-enabled'));
		}
		else
		{
			Flash::message(t('paragraphs.two-factor-google-disabled'));
		}

		return Redirect::back();
	}

	public function email()
	{
		$this->execute(RequestToggleEmailCommand::class, ['user' => Auth::user()]);

		return Redirect::back();
	}

	public function emailToggle($code)
	{
		$user = $this->execute(
			ToggleEmailCommand::class,
			[
				'code' => $code,
				'user' => Auth::user()
			]
		);

		if ($user->two_factor_email_enabled)
		{
			Flash::message(t('paragraphs.two-factor-email-enabled'));
		}
		else
		{
			Flash::message(t('paragraphs.two-factor-email-disabled'));
		}

		return Redirect::back();
	}

}
