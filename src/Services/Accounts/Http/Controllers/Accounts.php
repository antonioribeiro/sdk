<?php

namespace PragmaRX\Sdk\Services\Accounts\Http\Controllers;

use Redirect;
use PragmaRX\Sdk\Services\Accounts\Jobs\Activate;
use PragmaRX\Sdk\Core\Controller as BaseController;

class Accounts extends BaseController {

	/**
	 * Activate an account.
	 *
	 */
	public function activate($email, $token)
	{
		dispatch(new Activate($email, $token));

		return Redirect::route_no_ajax('notification', null, 302, [], ['no-return-ajax-url'])
				->with('title', t('titles.account-activated'))
				->with('message', t('paragraphs.account-activated'))
				->with('buttons', [[
									'caption' => t('captions.go-to-login-page'),
				                    'url' => route('auth.login')
				                   ]])
				->withInput();
	}
}
