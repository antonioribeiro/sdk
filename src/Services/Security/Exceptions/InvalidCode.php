<?php

namespace PragmaRX\Sdk\Services\Security\Exceptions;

use PragmaRX\Sdk\Core\HttpResponseException;

class InvalidCode extends HttpResponseException {

	protected $message = 'paragraphs.invalid-code';

}
