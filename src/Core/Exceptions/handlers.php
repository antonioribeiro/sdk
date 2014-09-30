<?php

App::error(function(PragmaRX\Sdk\Core\Exceptions\InvalidRequest $exception, $code)
{
	Flash::error(t('paragraphs.invalid-request'));

	return Redirect::home();
});

App::error(function(PragmaRX\Sdk\Core\Exceptions\TokenExpired $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-expired'));

	return Redirect::home();
});

App::error(function(PragmaRX\Sdk\Core\Exceptions\InvalidToken $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-invalid'));

	return Redirect::home();
});

