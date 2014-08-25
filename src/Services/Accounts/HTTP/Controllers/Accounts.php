<?php

namespace PragmaRX\Sdk\Services\Accounts\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;
use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Services\Accounts\Commands\ActivateCommand;

class Accounts extends BaseController {

	/**
	 * Activate an account.
	 *
	 */
	public function activate($email, $token)
	{
		$input = compact('email', 'token');

		$this->execute(ActivateCommand::class, $input);

		return Redirect::route('message')
			->with('title', t('titles.account-activated'))
			->with('message', t('paragraphs.account-activated'))
			->with('buttons', [[
								'caption' => t('captions.go-to-login-page'),
			                    'url' => route('login')
			                   ]])
			->withInput();
	}

}
