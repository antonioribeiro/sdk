<?php

namespace PragmaRX\SDK\Accounts;

use PragmaRX\SDK\Core\Controller as BaseController;
use Redirect;

class Controller extends BaseController {

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
