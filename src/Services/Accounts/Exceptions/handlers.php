<?php

use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidEmail;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;

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

App::make('exception')->error(function(InvalidPassword $exception, $code)
{
	Flash::error(t('paragraphs.invalid-password'));

	return Redirect::back()->withInput();
});

App::make('exception')->error(function(InvalidEmail $exception, $code)
{
	Flash::error(t('paragraphs.invalid-email'));

	return Redirect::back()->withInput();
});
