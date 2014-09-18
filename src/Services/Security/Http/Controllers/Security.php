<?php

namespace PragmaRX\Sdk\Services\Security\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Services\Security\Commands\ToggleGoogleCodeCommand;
use PragmaRX\Sdk\Services\TwoFactor\Data\Entities\TwoFactorType;
use PragmaRX\Sdk\Services\Security\Http\Requests\GoogleCodeRequest;
use View;
use Auth;
use Flash;

class Security extends BaseController {

	public function edit()
	{
		$selectTwoFactor = TwoFactorType::lists('name', 'id');

		return View::make('security.edit')
				->with('user', Auth::user())
				->with('selectTwoFactor', $selectTwoFactor);
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

}
