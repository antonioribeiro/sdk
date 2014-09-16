<?php

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidRequest $exception, $code)
{
	return Redirect::home()->withErrors(t('paragraphs.invalid-request'));
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\TokenExpired $exception, $code)
{
	return Redirect::home()->withErrors(t('paragraphs.two-factor-token-expired'));
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidToken $exception, $code)
{
	return Redirect::home()->withErrors(t('paragraphs.two-factor-token-invalid'));
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidAuthenticationCode $exception, $code)
{
	return Redirect::home()->withErrors(t('paragraphs.two-factor-invalid-auth-code'));
});

