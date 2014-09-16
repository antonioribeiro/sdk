<?php

use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidEmail;
use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Accounts\Exceptions\InvalidPassword;

App::error(function(UserAlreadyActivated $exception, $code)
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

App::error(function(InvalidPassword $exception, $code)
{
	return Redirect::back()->withInput()->withErrors(t('paragraphs.invalid-password'));
});

App::error(function(InvalidEmail $exception, $code)
{
	return Redirect::back()->withInput()->withErrors(t('paragraphs.invalid-email'));
});
