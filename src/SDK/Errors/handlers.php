<?php

App::error(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	Flash::errors($exception->getErrors());

	return \PragmaRX\Sdk\Core\Redirect::back()->withInput();
});
