<?php

App::make('exception')->error(function(PragmaRX\Sdk\Services\Passwords\Exceptions\InvalidPasswordUpdateRequest $exception, $code)
{
	Flash::error(t('paragraphs.invalid-password-update-request'));

	return Redirect::home();
});

App::make('exception')->error(function(PragmaRX\Sdk\Services\Passwords\Exceptions\EmailAndUsernameNotFound $exception, $code)
{
	Flash::error(t('paragraphs.user-not-found'));

	return Redirect::home();
});
