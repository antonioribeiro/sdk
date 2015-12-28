<?php

use PragmaRX\Sdk\Services\Accounts\Exceptions\UserAlreadyActivated;
use PragmaRX\Sdk\Services\Activation\Exceptions\UserNotActivated;

//ExceptionHandler::addHandler(function(Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception)
//{
//	Flash::error('page not found');
//
//	return Redirect::home();
//});

ExceptionHandler::addHandler(function(UserAlreadyActivated $exception, $code)
{
	return Redirect::route_no_ajax('notification')
			->with('title', t('titles.account-already-activated'))
			->with('message', t('paragraphs.account-already-activated'))
			->with('buttons', [[
				                   'caption' => t('captions.go-to-login-page'),
				                   'url' => route('auth.login')
			                   ]])
			->withInput();
});

ExceptionHandler::addHandler(function(UserNotActivated $exception, $code)
{
    return redirect()->route('notification')
                   ->with('title', t('titles.account-not-yet-activated'))
                   ->with('message', t('paragraphs.account-not-yet-activated'))
                   ->with('buttons', [[
                                          'caption' => t('captions.go-to-login-page'),
                                          'url' => route('auth.login')
                                      ]])
                   ->withInput();
});

ExceptionHandler::addHandler(function(UserAlreadyActivated $exception, $code)
{
	return Redirect::route_no_ajax('notification')
		->with('title', t('titles.account-already-activated'))
		->with('message', t('paragraphs.account-already-activated'))
		->with('buttons', [[
			                   'caption' => t('captions.go-to-login-page'),
			                   'url' => route('auth.login')
		                   ]])
		->withInput();
});
