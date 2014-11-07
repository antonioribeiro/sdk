<?php

ExceptionHandler::addHandler(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return Redirect::back()->withInput();
});

ExceptionHandler::addHandler(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	return Redirect::back()
			->withInput()
			->withErrors([t('paragraphs.token-mismatch')]);
});

ExceptionHandler::addHandler(function(Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception, $code)
{
	// Should this be a 404?

	Log::error('MethodNotAllowedHttpException');

	Flash::errors(t('paragraphs.invalid-request'));

	return Redirect::home();
});
