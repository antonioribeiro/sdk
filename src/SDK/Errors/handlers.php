<?php

App::make('exception')->error(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return Redirect::back()->withInput();
});

App::make('exception')->error(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	Flash::errors(t('paragraphs.token-mismatch'));

	return Redirect::back()->withInput();
});

App::make('exception')->error(function(Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $exception, $code)
{
	// Should this be a 404?

	Flash::errors(t('paragraphs.invalid-request'));

	return Redirect::home();
});
