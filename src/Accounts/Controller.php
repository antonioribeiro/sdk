<?php

namespace PragmaRX\SDK\Controllers;

use PragmaRX\SDK\Core\Controller as BaseController;
use Redirect;

use PragmaRX\SDK\Accounts\ActivateCommand;

class Controller extends BaseController {

	/**
	 * Activate an account.
	 *
	 */
	public function activate($email, $token)
	{
		$input = compact('email', 'token');

		$this->execute(ActivateCommand::class, $input);

		return Redirect::route('messages.index')
			->with('title', t('titles.account-activated'))
			->with('message', t('paragraphs.account-activated'))
			->with('buttons', [[
								'caption' => t('captions.go-to-login-page'),
			                    'url' => route('login')
			                   ]])
			->withInput();
	}

}
