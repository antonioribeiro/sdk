<?php

namespace PragmaRX\Sdk\Services\Security\Http\Controllers;

use View;
use Auth;
use Flash;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Services\Security\Http\Requests\GoogleCodeRequest;
use PragmaRX\Sdk\Services\Security\Jobs\ToggleEmail as ToggleEmailJob;
use PragmaRX\Sdk\Services\Security\Jobs\ToggleGoogleCode as ToggleGoogleCodeJob;
use PragmaRX\Sdk\Services\Security\Jobs\RequestToggleEmail as RequestToggleEmailJob;

class Security extends BaseController {

	public function edit()
	{
		return View::make('security.edit')->with('user', Auth::user());
	}

	public function google(GoogleCodeRequest $request)
	{
		$user = dispatch(new ToggleGoogleCodeJob(['user' => Auth::user()]));

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
		dispatch(new RequestToggleEmailJob(['user' => Auth::user()]));

		return Redirect::back();
	}

	public function emailToggle($code)
	{
	    $input = [
            'code' => $code,
            'user' => Auth::user()
        ];

		$user = dispatch(new ToggleEmailJob($input));

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
