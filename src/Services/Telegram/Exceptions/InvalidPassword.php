<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidPassword extends HttpResponseException {

	protected $message = 'paragraphs.invalid-password';

}
