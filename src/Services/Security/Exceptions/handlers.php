<?php

use PragmaRX\Sdk\Services\Security\Exceptions\InvalidCode;

App::error(function(InvalidCode $exception, $code)
{
	Flash::error(t('paragraphs.invalid-code'));

	return Redirect::back()->withInput();
});
