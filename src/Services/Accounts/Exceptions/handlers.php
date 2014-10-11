<?php

use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;

App::make('exception')->error(function(UserAlreadyActivated $exception, $code)
{
	return Redirect::route('message')
			->with('title', t('titles.account-already-activated'))
			->with('message', t('paragraphs.account-already-activated'))
			->with('buttons', [[
				                   'caption' => t('captions.go-to-login-page'),
				                   'url' => route('login')
			                   ]])
			->withInput();
});

