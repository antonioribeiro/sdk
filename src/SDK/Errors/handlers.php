<?php

ExceptionHandler::addHandler(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return Redirect::back()->withInput();
});

ExceptionHandler::addHandler(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	Flash::error(t('paragraphs.token-mismatch'));

	return Redirect::back();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\TokenMismatch $exception, $code)
{
	Flash::error(t('paragraphs.token-mismatch'));

	return Redirect::back()->withInput();
});

ExceptionHandler::addHandler(function(Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception, $code)
{
	// Should this be a 404?

	Log::error('MethodNotAllowedHttpException');

	Flash::errors(t('paragraphs.invalid-request'));

	return Redirect::home();
});
