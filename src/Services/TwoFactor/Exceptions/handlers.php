<?php

App::error(function(PragmaRX\Sdk\Services\TwoFactor\Exceptions\InvalidAuthenticationCode $exception, $code)
{
	Flash::error(t('paragraphs.two-factor-invalid-auth-code'));

	return Redirect::back()->withInput();
});
