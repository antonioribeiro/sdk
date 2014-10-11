<?php

namespace PragmaRX\Sdk\Services\Accounts\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidEmail extends HttpResponseException {

	protected $message = 'paragraphs.invalid-email';

}
