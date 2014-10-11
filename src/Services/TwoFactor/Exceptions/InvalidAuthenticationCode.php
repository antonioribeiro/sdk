<?php

namespace PragmaRX\Sdk\Services\TwoFactor\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidAuthenticationCode extends HttpResponseException {

	protected $message = 'paragraphs.two-factor-invalid-auth-code';

}
