<?php

App::error(function(Laracasts\Validation\FormValidationException $exception, $code)
{
	return Redirect::back()->withInput()->withErrors($exception->getErrors());
});
