<?php

use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;

ExceptionHandler::addHandler(function(Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception)
{
	Flash::error('page not found');

	return Redirect::home();
});

ExceptionHandler::addHandler(function(UserAlreadyActivated $exception, $code)
{
	return Redirect::route_no_ajax('message')
			->with('title', t('titles.account-already-activated'))
			->with('message', t('paragraphs.account-already-activated'))
			->with('buttons', [[
				                   'caption' => t('captions.go-to-login-page'),
				                   'url' => route('login')
			                   ]])
			->withInput();
});

