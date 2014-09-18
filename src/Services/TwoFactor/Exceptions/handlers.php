<?php

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidRequest $exception, $code)
{
	Flash::error(t('paragraphs.invalid-request'));

	return Redirect::home();
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\TokenExpired $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-expired'));

	return Redirect::home();
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidToken $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-token-invalid'));

	return Redirect::home();
});

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidAuthenticationCode $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-invalid-auth-code'));

	return Redirect::back()->withInput();
});
