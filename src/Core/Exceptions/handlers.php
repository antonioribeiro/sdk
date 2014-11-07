<?php

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\InvalidRequest $exception, $code)
{
	Flash::error(t('paragraphs.invalid-request'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\TokenExpired $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-expired'));

	return Redirect::home();
});

ExceptionHandler::addHandler(function(PragmaRX\Sdk\Core\Exceptions\InvalidToken $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-invalid'));

	return Redirect::home();
});

