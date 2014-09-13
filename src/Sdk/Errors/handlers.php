<?php

App::error(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return \PragmaRX\Sdk\Core\Redirect::back()->withInput();
});

App::error(function(Illuminate\Session\TokenMismatchException $exception, $code)
{
	Flash::errors(t('paragraphs.token-mismatch'));

	return \PragmaRX\Sdk\Core\Redirect::back()->withInput();
});

