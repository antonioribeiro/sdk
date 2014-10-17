<?php

App::make('exception')->error(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return Redirect::back()->withInput();
});

App::make('exception')->error(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	return Redirect::back()
			->withInput()
			->withErrors([t('paragraphs.token-mismatch')]);
});

App::make('exception')->error(function(Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception, $code)
{
	// Should this be a 404?

	Log::error('MethodNotAllowedHttpException');

	Flash::errors(t('paragraphs.invalid-request'));

	return Redirect::home();
});
